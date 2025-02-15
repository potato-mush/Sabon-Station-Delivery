<?php
include '_dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['removeUser'])) {
        $Id = $_POST["Id"];
        
        // Get the image path before deleting the user
        $stmt = $conn->prepare("SELECT image FROM users WHERE id = ?");
        $stmt->bind_param("i", $Id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];
        $stmt->close();

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $Id);
        
        if ($stmt->execute()) {
            // Delete the image file if it exists and is not the default
            if ($imagePath != 'profile/profilePic.jpg' && file_exists("../../img/" . $imagePath)) {
                unlink("../../img/" . $imagePath);
            }
            echo "<script>alert('Removed'); window.location=document.referrer;</script>";
        }
        $stmt->close();
    }
    
    if(isset($_POST['createUser'])) {
        $username = $_POST["username"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $userType = $_POST["userType"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        
        // Check whether this username exists
        $existSql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
            echo "<script>alert('Username Already Exists');
                    window.location=document.referrer;</script>";
        }
        else{
            if(($password == $cpassword)){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Set default relative path
                $db_image_path = "profile/profilePic.jpg";

                if (isset($_FILES["userimage"]) && $_FILES["userimage"]["error"] == 0) {
                    $file_extension = pathinfo($_FILES["userimage"]["name"], PATHINFO_EXTENSION);
                    $new_filename = 'profile_' . uniqid() . '.' . $file_extension;
                    $db_image_path = "profile/" . $new_filename; // Store relative path
                    $upload_path = "../../img/" . $db_image_path;
                    
                    if (!move_uploaded_file($_FILES["userimage"]["tmp_name"], $upload_path)) {
                        echo "<script>alert('Error uploading image');
                                window.location=document.referrer;</script>";
                        exit();
                    }
                }

                $sql = "INSERT INTO `users` (`username`, `firstName`, `lastName`, `email`, `phone`, `userType`, `password`, `joinDate`, `image`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), ?)";   
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssss", $username, $firstName, $lastName, $email, $phone, $userType, $hash, $db_image_path);
                
                if ($stmt->execute()){
                    echo "<script>alert('User created successfully');
                            window.location=document.referrer;</script>";
                }else {
                    echo "<script>alert('Failed to create user');
                            window.location=document.referrer;</script>";
                }
            }
            else{
                echo "<script>alert('Passwords do not match');
                    window.location=document.referrer;</script>";
            }
        }
    }
    
    if(isset($_POST['editUser'])) {
        $id = $_POST["userId"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $userType = $_POST["userType"];

        // Check if image was changed through file upload
        if(isset($_FILES['userimage']) && $_FILES['userimage']['error'] === UPLOAD_ERR_OK) {
            // Handle file upload
            $file_extension = pathinfo($_FILES['userimage']['name'], PATHINFO_EXTENSION);
            $new_filename = 'profile_' . uniqid() . '.' . $file_extension;
            $db_image_path = "profile/" . $new_filename;
            $upload_path = "../../img/" . $db_image_path;

            if(move_uploaded_file($_FILES['userimage']['tmp_name'], $upload_path)) {
                // Get and delete old image
                $stmt = $conn->prepare("SELECT image FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $oldImage = $row['image'];
                $stmt->close();

                if($oldImage != 'profile/profilePic.jpg' && file_exists("../../img/" . $oldImage)) {
                    unlink("../../img/" . $oldImage);
                }

                // Update with new image
                $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, phone=?, userType=?, image=? WHERE id=?");
                $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $phone, $userType, $db_image_path, $id);
            }
        }
        // Check if image was changed through base64 data
        else if(isset($_POST['imageChanged']) && $_POST['imageChanged'] == "1" && !empty($_POST['imageData'])) {
            $imageData = $_POST['imageData'];
            
            // Extract the base64 data
            if(preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);

                // Create new filename
                $new_filename = 'profile_' . uniqid() . '.jpg';
                $db_image_path = "profile/" . $new_filename;
                $upload_path = "../../img/" . $db_image_path;

                // Save new image
                if(file_put_contents($upload_path, $imageData)) {
                    // Get and delete old image
                    $stmt = $conn->prepare("SELECT image FROM users WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $oldImage = $row['image'];
                    $stmt->close();

                    if($oldImage != 'profile/profilePic.jpg' && file_exists("../../img/" . $oldImage)) {
                        unlink("../../img/" . $oldImage);
                    }

                    // Update with new image
                    $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, phone=?, userType=?, image=? WHERE id=?");
                    $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $phone, $userType, $db_image_path, $id);
                }
            }
        } else {
            // Update without changing image
            $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, phone=?, userType=? WHERE id=?");
            $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $userType, $id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Update successful'); window.location=document.referrer;</script>";
        } else {
            echo "<script>alert('Update failed: " . $stmt->error . "'); window.location=document.referrer;</script>";
        }
        $stmt->close();
    }
}
?>