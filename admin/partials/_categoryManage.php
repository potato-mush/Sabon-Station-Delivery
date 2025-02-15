<?php
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['createCategory'])) {
        $name = $_POST["name"];
        $desc = $_POST["desc"];

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = 'category_' . uniqid() . '.' . $file_extension;
            $upload_path = "../../img/category/" . $new_filename; // Physical path for file upload
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
                $sql = "INSERT INTO `categories` (`categorieName`, `categorieDesc`, `image`, `categorieCreateDate`) 
                        VALUES (?, ?, ?, current_timestamp())";
                $stmt = $conn->prepare($sql);
                $db_image_path = "category/" . $new_filename; // Store relative path in database
                $stmt->bind_param("sss", $name, $desc, $db_image_path);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Category added successfully');
                            window.location=document.referrer;</script>";
                }
                $stmt->close();
            }
        } else {
            // Use default image if no file uploaded
            $sql = "INSERT INTO `categories` (`categorieName`, `categorieDesc`, `categorieCreateDate`) 
                    VALUES ('$name', '$desc', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>alert('Category added with default image');
                        window.location=document.referrer;</script>";
            }
        }
    }

    if (isset($_POST['removeCategory'])) {
        $catId = $_POST["catId"];
        
        // Get image filename before deleting
        $stmt = $conn->prepare("SELECT image FROM `categories` WHERE `categorieId`=?");
        $stmt->bind_param("i", $catId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $imageFilename = $row['image'];
        $stmt->close();

        // Delete category
        $stmt = $conn->prepare("DELETE FROM `categories` WHERE `categorieId`=?");
        $stmt->bind_param("i", $catId);
        
        if ($stmt->execute()) {
            // Delete image file if exists
            if ($imageFilename && file_exists("../../img/category/" . basename($imageFilename))) {
                unlink("../../img/category/" . basename($imageFilename));
            }
            echo "<script>alert('Category removed');
                window.location=document.referrer;</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['updateCategory'])) {
        $catId = $_POST["catId"];
        $catName = $_POST["name"];
        $catDesc = $_POST["desc"];

        // Get current image filename
        $stmt = $conn->prepare("SELECT image FROM categories WHERE categorieId = ?");
        $stmt->bind_param("i", $catId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $oldImage = $row['image'];
        $stmt->close();

        if (isset($_FILES['catimage']) && $_FILES['catimage']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['catimage']['name'], PATHINFO_EXTENSION);
            $new_filename = 'category_' . uniqid() . '.' . $file_extension;
            $upload_path = "../../img/category/" . $new_filename; // Physical path for file upload

            if (move_uploaded_file($_FILES['catimage']['tmp_name'], $upload_path)) {
                // Delete old image if exists
                if ($oldImage && file_exists("../../img/category/" . basename($oldImage))) {
                    unlink("../../img/category/" . basename($oldImage));
                }
                
                $db_image_path = "category/" . $new_filename; // Store relative path in database
                $stmt = $conn->prepare("UPDATE `categories` SET `categorieName`=?, `categorieDesc`=?, `image`=? WHERE `categorieId`=?");
                $stmt->bind_param("sssi", $catName, $catDesc, $db_image_path, $catId);
            }
        } else {
            // Update without changing image
            $stmt = $conn->prepare("UPDATE `categories` SET `categorieName`=?, `categorieDesc`=? WHERE `categorieId`=?");
            $stmt->bind_param("ssi", $catName, $catDesc, $catId);
        }
        
        if ($stmt->execute()) {
            echo "<script>alert('Category updated successfully');
                    window.location=document.referrer;</script>";
        }
        $stmt->close();
    }
}
?>
