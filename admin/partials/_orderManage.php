<?php
include '_dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['updateStatus'])) {
        $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $sql = "UPDATE `orders` SET `orderStatus`=? WHERE `orderId`=?";   
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $status, $orderId);
        
        if (mysqli_stmt_execute($stmt)){
            echo "<script>
                alert('Status updated successfully');
                window.location=document.referrer;
                </script>";
        }
        else {
            echo "<script>
                alert('Failed to update status: " . mysqli_error($conn) . "');
                window.location=document.referrer;
                </script>";
        }
        mysqli_stmt_close($stmt);
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