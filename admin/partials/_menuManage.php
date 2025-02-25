<?php
include '_dbconnect.php';

// Create Item
if (isset($_POST['createItem'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $categoryId = $_POST['categoryId'];
    $stock = $_POST['stock'];
    $discount = $_POST['discount'];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $db_image_path = "products/" . $new_filename; // Store relative path in database
        $upload_path = "../../img/" . $db_image_path;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
            $sql = "INSERT INTO `products` (`productName`, `productDesc`, `productPrice`, `productCategorieId`, `image`, `stock`, `discount`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdisid", $name, $description, $price, $categoryId, $db_image_path, $stock, $discount);

            if ($stmt->execute()) {
                echo "<script>alert('Item created successfully.'); window.location=document.referrer;</script>";
            } else {
                unlink($upload_path); // Delete the uploaded file if database insert fails
                echo "<script>alert('Failed to create item.'); window.location=document.referrer;</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload image.'); window.location=document.referrer;</script>";
        }
    }
}

// Update Item
if (isset($_POST['updateItem'])) {
    $productId = $_POST['productId'];
    $name = $_POST['name'];
    $description = $_POST['desc'];
    $price = $_POST['price'];
    $categoryId = $_POST['categoryId'];
    $stock = $_POST['stock'];
    $discount = $_POST['discount'];

    // First get the current image filename
    $oldImageQuery = "SELECT image FROM products WHERE productId = ?";
    $stmt = $conn->prepare($oldImageQuery);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $oldImage = $row['image'];
    $stmt->close();

    $new_filename = $oldImage; // Default to keeping old image

    // Only process image if one was uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $db_image_path = "products/" . $new_filename;
        $upload_path = "../../img/" . $db_image_path;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
            // Delete old image
            if ($oldImage && file_exists("../../img/" . $oldImage)) {
                unlink("../../img/" . $oldImage);
            }
            $new_filename = $db_image_path;
        } else {
            echo "<script>alert('Failed to upload new image. Using existing image.'); </script>";
            $new_filename = $oldImage;
        }
    }

    // Update product details
    $updateSql = "UPDATE `products` SET `productName`=?, `productDesc`=?, `productPrice`=?, 
                  `productCategorieId`=?, `image`=?, `stock`=?, `discount`=? WHERE `productId`=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssdisidi", $name, $description, $price, $categoryId, $new_filename, $stock, $discount, $productId);

    if ($updateStmt->execute()) {
        echo "<script>alert('Item updated successfully.'); window.location=document.referrer;</script>";
    } else {
        echo "<script>alert('Failed to update item.'); window.location=document.referrer;</script>";
    }
    $updateStmt->close();
}

// Remove Item
if (isset($_POST['removeItem'])) {
    $productId = $_POST['productId'];

    // First get the image filename
    $imageQuery = "SELECT image FROM products WHERE productId = ?";
    $stmt = $conn->prepare($imageQuery);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $image = $row['image'];
    $stmt->close();

    // Delete the product
    $removeSql = "DELETE FROM `products` WHERE `productId`=?";
    $removeStmt = $conn->prepare($removeSql);
    $removeStmt->bind_param("i", $productId);

    if ($removeStmt->execute()) {
        // Delete the image file with full path
        if ($image && file_exists("../../img/" . $image)) {
            unlink("../../img/" . $image);
        }
        echo "<script>alert('Item deleted successfully.'); window.location=document.referrer;</script>";
    } else {
        echo "<script>alert('Failed to delete item.'); window.location=document.referrer;</script>";
    }
    $removeStmt->close();
}

// Function to handle upload errors
function handleUploadError($error) {
    switch ($error) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "<script>alert('Error: File exceeds the maximum size limit.'); window.location=document.referrer;</script>";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "<script>alert('Error: No file was uploaded.'); window.location=document.referrer;</script>";
            break;
        default:
            echo "<script>alert('Failed to upload image.'); window.location=document.referrer;</script>";
            break;
    }
}
?>
