<?php
include '../../partials/_dbconnect.php';  // Fix the database connection path

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['updateStatus'])) {
        $orderId = $_POST['orderId'];
        $status = $_POST['status'];

        // First get the current status and userId
        $sql = "SELECT orderStatus, userId FROM orders WHERE orderId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $oldStatus = $row['orderStatus'];
        $userId = $row['userId'];

        // Only proceed if status is different
        if($status != $oldStatus) {
            // Update order status
            $updateSql = "UPDATE orders SET orderStatus = ? WHERE orderId = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ii", $status, $orderId);
            
            if($stmt->execute()) {
                // Generate status message
                $statusMsg = "";
                switch($status) {
                    case 0:
                        $statusMsg = "Order Placed";
                        break;
                    case 1:
                        $statusMsg = "Order Confirmed";
                        break;
                    case 2:
                        $statusMsg = "Preparing your Order";
                        break;
                    case 3:
                        $statusMsg = "Your order is on the way!";
                        break;
                    case 4:
                        $statusMsg = "Order Delivered";
                        break;
                    case 5:
                        $statusMsg = "Order Denied";
                        break;
                    case 6:
                        $statusMsg = "Order Cancelled";
                        break;
                }

                // Create notification
                $message = "Your order #" . $orderId . " has been updated: " . $statusMsg;
                $notifSql = "INSERT INTO notifications (userId, orderId, message, status) VALUES (?, ?, ?, 0)";
                $stmt = $conn->prepare($notifSql);
                $stmt->bind_param("iis", $userId, $orderId, $message);
                $stmt->execute();

                echo "<script>
                    alert('Order status updated successfully to: " . $statusMsg . "');
                    window.location.href = '../index.php';
                    </script>";
            } else {
                echo "<script>
                    alert('Failed to update order status: " . $conn->error . "');
                    window.location.href = '../index.php';
                    </script>";
            }
        } else {
            echo "<script>
                alert('No change in order status');
                window.location.href = '../index.php';
                </script>";
        }
        exit();
    }
    
    if(isset($_POST['updateDeliveryDetails'])) {
        $trackId = mysqli_real_escape_string($conn, $_POST['trackId']);
        $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        
        if($trackId == NULL) {
            $sql = "INSERT INTO `deliverydetails` (`orderId`, `deliveryBoyName`, `deliveryBoyPhoneNo`, `deliveryTime`, `dateTime`) VALUES (?, ?, ?, ?, current_timestamp())";   
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $orderId, $name, $phone, $time);
            
            if (mysqli_stmt_execute($stmt)){
                echo "<script>
                    alert('Delivery details added successfully');
                    window.location=document.referrer;
                    </script>";
            }
            else {
                echo "<script>
                    alert('Failed to add delivery details: " . mysqli_error($conn) . "');
                    window.location=document.referrer;
                    </script>";
            }
            mysqli_stmt_close($stmt);
        }
        else {
            $sql = "UPDATE `deliverydetails` SET `deliveryBoyName`=?, `deliveryBoyPhoneNo`=?, `deliveryTime`=?, `dateTime`=current_timestamp() WHERE `id`=?";   
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $time, $trackId);
            
            if (mysqli_stmt_execute($stmt)){
                echo "<script>
                    alert('Delivery details updated successfully');
                    window.location=document.referrer;
                    </script>";
            }
            else {
                echo "<script>
                    alert('Failed to update delivery details: " . mysqli_error($conn) . "');
                    window.location=document.referrer;
                    </script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}

?>