<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title>Cart</title>
    <link rel = "icon" href ="img/logo.jpg" type = "image/x-icon">
    <style>
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    #cont {
        flex: 1;
    }
    </style>
</head>
<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php require 'partials/_nav.php' ?>
    <?php 
    if($loggedin){
    ?>
    
    <div class="container" id="cont">
        <div class="row">
            <div class="col-lg-12 text-center border rounded bg-light my-3">
                <h1>My Cart</h1>
            </div>
            <div class="col-lg-8">
                <div class="card wish-list mb-3">
                    <table class="table text-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="selectAll" onclick="toggleAll()">
                                </th>
                                <th scope="col">No.</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">
                                    <form action="partials/_manageCart.php" method="POST">
                                        <button name="removeAllItem" class="btn btn-sm btn-outline-danger">Remove All</button>
                                        <input type="hidden" name="userId" value="<?php $userId = $_SESSION['userId']; echo $userId ?>">
                                    </form>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM `viewcart` WHERE `userId`= $userId";
                                $result = mysqli_query($conn, $sql);
                                $counter = 0;
                                $totalPrice = 0;
                                while($row = mysqli_fetch_assoc($result)){
                                    $productId = $row['productId'];
                                    $Quantity = $row['itemQuantity'];
                                    $mysql = "SELECT * FROM `products` WHERE productId = $productId";
                                    $myresult = mysqli_query($conn, $mysql);
                                    $myrow = mysqli_fetch_assoc($myresult);
                                    $productName = $myrow['productName'];
                                    $productPrice = $myrow['productPrice'];
                                    $productDiscount = $myrow['discount'];
                                    $productStock = $myrow['stock'];

                                    // Calculate discounted price
                                    $finalPrice = $productPrice;
                                    if ($productDiscount > 0) {
                                        $finalPrice = $productPrice - ($productPrice * ($productDiscount / 100));
                                    }
                                    
                                    $total = $finalPrice * $Quantity;
                                    $counter++;
                                    $totalPrice = $totalPrice + $total;

                                    echo '<tr>
                                            <td>
                                                <input type="checkbox" class="itemCheckbox" 
                                                    data-price="' . $total . '"
                                                    data-product-id="' . $productId . '" 
                                                    onclick="updateTotal()">
                                            </td>
                                            <td>' . $counter . '</td>
                                            <td>' . $productName . '</td>
                                            <td>';
                                    if ($productDiscount > 0) {
                                        echo '<s class="text-muted">₱' . $productPrice . '</s><br>
                                              <span class="text-success">₱' . number_format($finalPrice, 2) . '</span>
                                              <small class="text-muted">(' . $productDiscount . '% OFF)</small>';
                                    } else {
                                        echo '₱' . number_format($productPrice, 2);
                                    }
                                    echo '</td>
                                            <td>
                                                <form id="frm' . $productId . '">
                                                    <input type="hidden" name="productId" value="' . $productId . '">
                                                    <input type="number" name="quantity" value="' . $Quantity . '" class="text-center" 
                                                    onchange="updateCart(' . $productId . ')" 
                                                    onkeyup="return false" 
                                                    style="width:60px" 
                                                    min="1" 
                                                    max="' . $productStock . '" 
                                                    oninput="checkStock(this, ' . $productStock . ')" 
                                                    onClick="this.select();">
                                                    <div class="small text-muted">Max: ' . $productStock . '</div>
                                                </form>
                                            </td>
                                            <td>' . $total . '</td>
                                            <td>
                                                <form action="partials/_manageCart.php" method="POST">
                                                    <button name="removeItem" class="btn btn-sm btn-outline-danger">Remove</button>
                                                    <input type="hidden" name="itemId" value="'.$productId. '">
                                                </form>
                                            </td>
                                        </tr>';
                                }
                                if($counter==0) {
                                    ?><script> document.getElementById("cont").innerHTML = '<div class="col-md-12 my-5"><div class="card"><div class="card-body cart"><div class="col-sm-12 empty-cart-cls text-center"> <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3"><h3><strong>Your Cart is Empty</strong></h3><h4>Add something to make me happy :)</h4> <a href="index.php" class="btn btn-primary cart-btn-transform m-3" data-abc="true">continue shopping</a> </div></div></div></div>';</script> <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card wish-list mb-3">
                    <div class="pt-4 border bg-light rounded p-3">
                        <h5 class="mb-3 text-uppercase font-weight-bold text-center">Order summary</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 bg-light">Total Price<span>₱ <span id="selectedTotal">0.00</span></span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-light">Shipping<span>₱ 0</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 bg-light">
                                <div>
                                    <strong>The total amount of</strong>
                                    <strong><p class="mb-0">(including Tax & Charge)</p></strong>
                                </div>
                                <span><strong>₱ <span id="finalTotal">0.00</span></strong></span>
                            </li>
                        </ul>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cash On Delivery 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="flexRadioDefault2" onclick="showGcashModal()">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Online Payment 
                            </label>
                        </div><br>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#checkoutModal">Checkout</button>
                        <!-- GCash Modal -->
                        <div class="modal fade" id="gcashModal" tabindex="-1" role="dialog" aria-labelledby="gcashModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="gcashModalLabel">GCash Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="img/qrCode.jpg" alt="GCash QR Code" class="img-fluid">
                                        <p>Scan the QR code to complete your payment.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                
    <?php 
    }
    else {
        echo '<div class="container" id="cont">
        <div class="alert alert-info my-3">
            <font style="font-size:22px"><center>Before checkout you need to <strong><a class="alert-link" data-toggle="modal" data-target="#loginModal">Login</a></strong></center></font>
        </div></div>';
    }
    ?>
    <?php require 'partials/_checkoutModal.php'; ?>
    <?php require 'partials/_footer.php' ?>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>         
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
    <script>
        function check(input) {
            if (input.value <= 0) {
                input.value = 1;
            }
        }
        function updateCart(id) {
            $.ajax({
                url: 'partials/_manageCart.php',
                type: 'POST',
                data: $("#frm"+id).serialize(),
                success: function(response) {
                    let result = JSON.parse(response);
                    if(result.error) {
                        alert(result.error);
                        location.reload();
                    } else if(result.success) {
                        location.reload();
                    }
                }
            });
        }

        function checkStock(input, maxStock) {
            if (input.value > maxStock) {
                input.value = maxStock;
                alert('Cannot exceed available stock of ' + maxStock + ' units');
            }
            if (input.value <= 0) {
                input.value = 1;
            }
            // Trigger cart update when stock is checked
            let formId = input.closest('form').id;
            let productId = formId.replace('frm', '');
            updateCart(productId);
        }

        function showGcashModal() {
            $('#gcashModal').modal('show');
        }

        // Add event listeners to quantity inputs
        document.addEventListener('DOMContentLoaded', function() {
            let quantityInputs = document.querySelectorAll('input[name="quantity"]');
            quantityInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    let maxStock = this.getAttribute('max');
                    checkStock(this, maxStock);
                });
            });
        });

        // Add this at the end of your existing script section
        function toggleAll() {
            let selectAllCheckbox = document.getElementById('selectAll');
            let itemCheckboxes = document.getElementsByClassName('itemCheckbox');
            
            for(let checkbox of itemCheckboxes) {
                checkbox.checked = selectAllCheckbox.checked;
            }
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            let checkboxes = document.getElementsByClassName('itemCheckbox');
            
            for(let checkbox of checkboxes) {
                if(checkbox.checked) {
                    total += parseFloat(checkbox.dataset.price);
                }
            }
            
            document.getElementById('selectedTotal').textContent = total.toFixed(2);
            document.getElementById('finalTotal').textContent = total.toFixed(2);
            
            // Update hidden amount field in checkout form if it exists
            let amountInput = document.querySelector('input[name="amount"]');
            if(amountInput) {
                amountInput.value = total;
            }
        }
    </script>
</body>
</html>