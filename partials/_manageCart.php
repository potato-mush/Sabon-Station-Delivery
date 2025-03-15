<?php
include '_dbconnect.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['userId'];
    if(isset($_POST['addToCart'])) {
        $itemId = $_POST["itemId"];
        
        // Check stock availability
        $stockSql = "SELECT stock FROM `products` WHERE productId = '$itemId'";
        $stockResult = mysqli_query($conn, $stockSql);
        $stockRow = mysqli_fetch_assoc($stockResult);
        
        if($stockRow['stock'] <= 0) {
            echo "<script>alert('Sorry, this item is out of stock.');
                    window.history.back(1);
                    </script>";
            exit();
        }

        // Check whether this item exists in cart
        $existSql = "SELECT * FROM `viewcart` WHERE productId = '$itemId' AND `userId`='$userId'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
            echo "<script>alert('Item Already Added.');
                    window.history.back(1);
                    </script>";
        }
        else{
            // Get the product image name
            $productSql = "SELECT * FROM `products` WHERE productId = '$itemId'";
            $productResult = mysqli_query($conn, $productSql);
            $productRow = mysqli_fetch_assoc($productResult);
            
            // Insert into cart with image filename
            $sql = "INSERT INTO `viewcart` (`productId`, `itemQuantity`, `userId`, `addedDate`) VALUES ('$itemId', '1', '$userId', current_timestamp())";   
            $result = mysqli_query($conn, $sql);
            if ($result){
                echo "<script>
                    window.history.back(1);
                    </script>";
            }
        }
    }
    if(isset($_POST['removeItem'])) {
        $itemId = $_POST["itemId"];
        $sql = "DELETE FROM `viewcart` WHERE `productId`='$itemId' AND `userId`='$userId'";   
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('Removed');
                window.history.back(1);
            </script>";
    }
    if(isset($_POST['removeAllItem'])) {
        $sql = "DELETE FROM `viewcart` WHERE `userId`='$userId'";   
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('Removed All');
                window.history.back(1);
            </script>";
    }
    if(isset($_POST['checkout'])) {
        $amount = $_POST["amount"];
        $address1 = $_POST["address"];
        $address2 = $_POST["address1"];
        $phone = $_POST["phone"];
        $zipcode = $_POST["zipcode"];
        $password = $_POST["password"];
        $selectedItems = isset($_POST["selectedItems"]) ? $_POST["selectedItems"] : [];
        $address = $address1.", ".$address2;

        if(empty($selectedItems)) {
            echo '<script>
                    alert("Please select at least one item to checkout.");
                    window.history.back(1);
                  </script>';
            exit();
        }
        
        $passSql = "SELECT * FROM users WHERE id='$userId'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow=mysqli_fetch_assoc($passResult);
        $userName = $passRow['username'];
        
        if (password_verify($password, $passRow['password'])) {
            $conn->begin_transaction();
            
            try {
                // Modify cart query to only check selected items
                $cartSql = "SELECT vc.productId, vc.itemQuantity, p.stock, p.productName 
                           FROM viewcart vc 
                           JOIN products p ON vc.productId = p.productId 
                           WHERE vc.userId = ? AND vc.productId IN (" . implode(',', array_fill(0, count($selectedItems), '?')) . ")";
                $stmt = $conn->prepare($cartSql);
                $types = "i" . str_repeat("i", count($selectedItems));
                $params = array_merge([$userId], $selectedItems);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $cartResult = $stmt->get_result();
                
                // Check if any item exceeds available stock
                while($cartItem = $cartResult->fetch_assoc()) {
                    if($cartItem['itemQuantity'] > $cartItem['stock']) {
                        throw new Exception("Sorry, " . $cartItem['productName'] . " only has " . $cartItem['stock'] . " items available.");
                    }
                }
                
                // Create the order
                $orderSql = "INSERT INTO `orders` (`userId`, `address`, `zipCode`, `phoneNo`, `amount`, `paymentMode`, `orderStatus`, `orderDate`) 
                            VALUES (?, ?, ?, ?, ?, '0', '0', current_timestamp())";
                $stmt = $conn->prepare($orderSql);
                $stmt->bind_param("isssd", $userId, $address, $zipcode, $phone, $amount);
                $stmt->execute();
                $orderId = $conn->insert_id;
                
                // Get cart items again for processing
                $stmt = $conn->prepare($cartSql);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $cartResult = $stmt->get_result();
                
                // Process each cart item
                while($cartItem = $cartResult->fetch_assoc()) {
                    // Insert into orderitems
                    $itemSql = "INSERT INTO `orderitems` (`orderId`, `productId`, `itemQuantity`) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($itemSql);
                    $stmt->bind_param("iii", $orderId, $cartItem['productId'], $cartItem['itemQuantity']);
                    $stmt->execute();
                    
                    // Update product stock
                    $newStock = $cartItem['stock'] - $cartItem['itemQuantity'];
                    $updateStockSql = "UPDATE `products` SET `stock` = ? WHERE `productId` = ?";
                    $stmt = $conn->prepare($updateStockSql);
                    $stmt->bind_param("ii", $newStock, $cartItem['productId']);
                    $stmt->execute();
                }
                
                // Only remove selected items from cart
                $deletesql = "DELETE FROM `viewcart` WHERE `userId`= ? AND productId IN (" . implode(',', array_fill(0, count($selectedItems), '?')) . ")";
                $stmt = $conn->prepare($deletesql);
                $types = "i" . str_repeat("i", count($selectedItems));
                $params = array_merge([$userId], $selectedItems);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                
                // Commit transaction
                $conn->commit();
                
                echo '<script>
                        alert("Thanks for ordering with us. Your order id is ' .$orderId. '.");
                        window.location.href="../index.php";
                      </script>';
                exit();
                
            } catch (Exception $e) {
                // Rollback on error
                $conn->rollback();
                echo '<script>
                        alert("' . $e->getMessage() . '");
                        window.history.back(1);
                      </script>';
                exit();
            }
        } else {
            echo '<script>
                    alert("Incorrect Password! Please enter correct Password.");
                    window.history.back(1);
                  </script>';
            exit();
        }    
    }
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        $productId = $_POST['productId'];
        $qty = $_POST['quantity'];
        
        // Check stock availability
        $stockSql = "SELECT stock FROM `products` WHERE productId = ?";
        $stmt = $conn->prepare($stockSql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stockRow = $result->fetch_assoc();
        $stmt->close();
        
        if($qty > $stockRow['stock']) {
            echo json_encode(['error' => 'Cannot exceed available stock of ' . $stockRow['stock'] . ' units']);
            exit();
        }
        
        if($qty < 1) {
            $qty = 1;
        }
        
        $updatesql = "UPDATE `viewcart` SET `itemQuantity`=? WHERE `productId`=? AND `userId`=?";
        $stmt = $conn->prepare($updatesql);
        $stmt->bind_param("iii", $qty, $productId, $userId);
        $updateresult = $stmt->execute();
        $stmt->close();
        
        if($updateresult) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update cart']);
        }
        exit();
    }
    
}
?>