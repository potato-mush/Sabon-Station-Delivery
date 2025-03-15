<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="checkoutModal">Enter Your Details:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="partials/_manageCart.php" method="post" id="checkoutForm">
                <!-- Add hidden input for selected items -->
                <div id="selectedItemsContainer"></div>
                <div class="form-group">
                    <b><label for="address">Address:</label></b>
                    <input class="form-control" id="address" name="address" placeholder="1234 Main St" type="text" required minlength="3" maxlength="500">
                </div>
                <div class="form-group">
                    <b><label for="address1">Address Line 2:</label></b>
                    <input class="form-control" id="address1" name="address1" placeholder="near st, Brgy., City" type="text">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <b><label for="phone">Phone No:</label></b>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon">+63</span>
                        </div>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="xxxxxxxxxx" required pattern="[0-9]{10}" maxlength="10">
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <b><label for="zipcode">Zip Code:</label></b>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="xxxx" required pattern="[0-9]{4}" maxlength="6">                    
                    </div>
                </div>
                <div class="form-group">
                    <b><label for="password">Password:</label></b>    
                    <input class="form-control" id="password" name="password" placeholder="Enter Password" type="password" required minlength="4" maxlength="21" data-toggle="password">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="hidden" name="amount" value="0">
                    <button type="submit" name="checkout" class="btn btn-success" onclick="return validateSelection()">Order</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script>
function validateSelection() {
    let checkboxes = document.getElementsByClassName('itemCheckbox');
    let selected = false;
    let selectedItems = [];
    
    for(let checkbox of checkboxes) {
        if(checkbox.checked) {
            selected = true;
            selectedItems.push(checkbox.dataset.productId);
        }
    }
    
    if(!selected) {
        alert('Please select at least one item to checkout.');
        return false;
    }

    // Add selected items to form
    let container = document.getElementById('selectedItemsContainer');
    container.innerHTML = ''; // Clear previous
    selectedItems.forEach(itemId => {
        container.innerHTML += `<input type="hidden" name="selectedItems[]" value="${itemId}">`;
    });
    
    return true;
}
</script>

<?php 
    if($loggedin){
        // Check stock availability for all cart items
        $stockError = false;
        $errorMessage = '';
        
        $cartSql = "SELECT p.productId, p.productName, p.stock, vc.itemQuantity 
                    FROM viewcart vc 
                    JOIN products p ON vc.productId = p.productId 
                    WHERE vc.userId='$userId'";
        $cartResult = mysqli_query($conn, $cartSql);
        
        while($row = mysqli_fetch_assoc($cartResult)) {
            if($row['itemQuantity'] > $row['stock']) {
                $stockError = true;
                $errorMessage .= $row['productName'] . ' has only ' . $row['stock'] . ' items available.\n';
            }
        }
        
        if($stockError) {
            echo '<script>
                    alert("Stock availability has changed:\n' . $errorMessage . '\nPlease update your cart.");
                    window.location.href="viewCart.php";
                  </script>';
            exit();
        }
    }
?>