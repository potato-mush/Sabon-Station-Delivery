<?php
    include '_dbconnect.php';
    session_start();
    $userId = $_SESSION['userId'];
    
    if(isset($_POST["updateProfileDetail"])){
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password-edit"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $zipcode = $_POST["zipcode"];

        // Get raw password from database for comparison
        $passSql = "SELECT password FROM users WHERE id='$userId'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow = mysqli_fetch_assoc($passResult);
        
        // Direct comparison since password is already hashed in database
        if ($passRow['password-edit'] === $password) {
            // Update profile details including address
            $sql = "UPDATE users SET firstName='$firstName', lastName='$lastName', email='$email', 
                    phone='$phone', address='$address', city='$city', zipcode='$zipcode' 
                    WHERE id='$userId'";
            $result = mysqli_query($conn, $sql);
            
            // Handle image upload if present
            if(!empty($_FILES["userimage"]["name"])) {
                $check = getimagesize($_FILES["userimage"]["tmp_name"]);
                if($check !== false) {
                    $uniqueId = uniqid();
                    $newfilename = "profile_" . $uniqueId . ".jpg";
                    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/SabonStationDelivery-main/Original/img/profile/';
                    if (!file_exists($uploaddir)) {
                        mkdir($uploaddir, 0777, true);
                    }
                    $uploadfile = $uploaddir . $newfilename;
                    $dbImagePath = 'profile/' . $newfilename;
                    
                    if (move_uploaded_file($_FILES['userimage']['tmp_name'], $uploadfile)) {
                        $sql = "UPDATE users SET image='$dbImagePath' WHERE id='$userId'";
                        $result = mysqli_query($conn, $sql);
                    }
                }
            } else if(isset($_POST['removeProfilePic'])) {
                // Remove profile picture
                $sql = "UPDATE users SET image=NULL WHERE id='$userId'";
                $result = mysqli_query($conn, $sql);
            }
            
            if($result) {
                echo '<script>alert("Profile updated successfully.");
                        window.location=document.referrer;
                    </script>';
            } else {
                echo '<script>alert("Update failed, please try again.");
                        window.location=document.referrer;
                    </script>';
            }
        } else {
            echo '<script>alert("Password is incorrect. Please try again.");
                    window.location=document.referrer;</script>';
        }
    }
?>