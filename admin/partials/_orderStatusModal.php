<?php 
$itemModalSql = "SELECT * FROM `orders`";
$itemModalResult = mysqli_query($conn, $itemModalSql);
while ($itemModalRow = mysqli_fetch_assoc($itemModalResult)) {
    $orderid = $itemModalRow['orderId'];
    $userid = $itemModalRow['userId'];
    $orderStatus = $itemModalRow['orderStatus'];
?>

<!-- Modal -->
<div class="modal fade" id="orderStatus<?php echo $orderid; ?>" tabindex="-1" role="dialog" aria-labelledby="orderStatus<?php echo $orderid; ?>Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(111 202 203);">
        <h5 class="modal-title" id="orderStatus<?php echo $orderid; ?>">Order Status and Delivery Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="partials/_orderManage.php" method="post" style="border-bottom: 2px solid #dee2e6;">
            <div class="text-left my-2">    
                <b><label for="status">Order Status</label></b>
                <div class="row mx-2">
                    <select class="form-control col-md-3" id="status" name="status" required>
                        <option value="0" <?php if($orderStatus == 0) echo "selected"; ?>>Order Placed</option>
                        <option value="1" <?php if($orderStatus == 1) echo "selected"; ?>>Order Confirmed</option>
                        <option value="2" <?php if($orderStatus == 2) echo "selected"; ?>>Preparing Order</option>
                        <option value="3" <?php if($orderStatus == 3) echo "selected"; ?>>On the way</option>
                        <option value="4" <?php if($orderStatus == 4) echo "selected"; ?>>Delivered</option>
                        <option value="5" <?php if($orderStatus == 5) echo "selected"; ?>>Denied</option>
                        <option value="6" <?php if($orderStatus == 6) echo "selected"; ?>>Cancelled</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="orderId" value="<?php echo $orderid; ?>">
            <button type="submit" class="btn btn-success" name="updateStatus">Update Status</button>
        </form>

        <?php 
        $deliveryDetailSql = "SELECT * FROM `deliverydetails` WHERE `orderId`= ?";
        $stmt = $conn->prepare($deliveryDetailSql);
        $stmt->bind_param("i", $orderid);
        $stmt->execute();
        $deliveryDetailResult = $stmt->get_result();
        
        // Initialize variables
        $trackId = null;
        $deliveryBoyName = '';
        $deliveryBoyPhoneNo = '';
        $deliveryTime = '';

        if ($deliveryDetailRow = $deliveryDetailResult->fetch_assoc()) {
            $trackId = $deliveryDetailRow['id'];
            $deliveryBoyName = $deliveryDetailRow['deliveryBoyName'];
            $deliveryBoyPhoneNo = $deliveryDetailRow['deliveryBoyPhoneNo'];
            $deliveryTime = $deliveryDetailRow['deliveryTime'];
        }

        // Show form if status is between 1-4, regardless of existing delivery details
        if ($orderStatus > 0 && $orderStatus < 5) { 
        ?>
            <form action="partials/_orderManage.php" method="post">
                <div class="text-left my-2">
                    <b><label for="name">Delivery Boy Name</label></b>
                    <input class="form-control" id="name" name="name" value="<?php echo $deliveryBoyName; ?>" type="text" required>
                </div>
                <div class="text-left my-2 row">
                    <div class="form-group col-md-6">
                        <b><label for="phone">Phone No</label></b>
                        <input class="form-control" id="phone" name="phone" value="<?php echo $deliveryBoyPhoneNo; ?>" type="tel" required pattern="[0-9]{10}">
                    </div>
                    <div class="form-group col-md-6">
                        <b><label for="catId">Estimate Time(minute)</label></b>
                        <input class="form-control" id="time" name="time" value="<?php echo $deliveryTime; ?>" type="number" min="1" max="120" required>
                    </div>
                </div>
                <input type="hidden" id="trackId" name="trackId" value="<?php echo $trackId; ?>">
                <input type="hidden" id="orderId" name="orderId" value="<?php echo $orderid; ?>">
                <button type="submit" class="btn btn-success" name="updateDeliveryDetails">Update</button>
            </form>
        <?php 
        } else {
            echo "<p>Delivery details can only be added for orders with status 1-4.</p>";
        }
        $stmt->close();
        ?>
      </div>
    </div>
  </div>
</div>

<?php
}
?>

<style>
    .popover {
        top: -77px !important;
    }
</style>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
        // Remove the Ajax form submission to allow normal form submission
    });
</script>
