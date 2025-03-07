<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title id="title">Category</title>
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
    <style>
        html, body {
          height: 100%;
          margin: 0;
        }
        body {
          display: flex;
          flex-direction: column;
        }
        .content {
          flex: 1 0 auto;
        }
        footer {
          flex-shrink: 0;
          width: 100%;
        }
        
        .jumbotron {
            padding: 2rem 1rem;
        }

        #cont {
            min-height: 570px;
        }

        .card {
            height: 100%;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            width: 100%;
            height: 270px;
            object-fit: cover;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .product-info {
            flex-grow: 1;
        }

        .price-section {
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .button-section {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .stock-status {
            margin: 0.5rem 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 15px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php require 'partials/_nav.php' ?>

    <div class="content">
        <div>&nbsp;
            <a href="index.php" class="active text-dark">
                <i class="fas fa-qrcode"></i>
                <span>All Category</span>
            </a>
        </div>

        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE categorieId = $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $catname = $row['categorieName'];
            $catdesc = $row['categorieDesc'];
        }
        ?>

        <!-- product container starts here -->
        <div class="container my-3" id="cont">
            <div class="col-lg-4 text-center bg-light my-3" style="margin:auto;border-top: 2px groove black;border-bottom: 2px groove black;">
                <h2 class="text-center"><span id="catTitle">Items</span></h2>
            </div>
            <div class="product-grid">
                <?php
                $id = $_GET['catid'];
                $sql = "SELECT * FROM `products` WHERE productCategorieId = $id";
                $result = mysqli_query($conn, $sql);
                $noResult = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noResult = false;
                    $productId = $row['productId'];
                    $productName = $row['productName'];
                    $productPrice = $row['productPrice'];
                    $productDesc = $row['productDesc'];
                    $productImage = $row['image'];
                    $productStock = $row['stock'];
                    $productDiscount = $row['discount'];
                    
                    // Calculate discounted price
                    $discountedPrice = $productPrice - ($productPrice * ($productDiscount / 100));

                    echo '<div class="card">
                            <img src="img/' . $productImage . '" class="card-img-top" alt="' . $productName . '">
                            <div class="card-body">
                                <div class="product-info">
                                    <h5 class="card-title">' . substr($productName, 0, 20) . '...</h5>
                                    <p class="card-text">' . substr($productDesc, 0, 29) . '...</p>
                                </div>
                                
                                <div class="price-section">';
                    if ($productDiscount > 0) {
                        echo '<h6 class="mb-0"><s style="color: red">₱' . $productPrice . '/-</s></h6>
                              <h6 class="mb-0" style="color: green">₱' . number_format($discountedPrice, 2) . '/- (' . $productDiscount . '% OFF)</h6>';
                    } else {
                        echo '<h6 class="mb-0" style="color: green">₱' . $productPrice . '/-</h6>';
                    }
                    echo '</div>';
                    
                    echo '<div class="stock-status text-center">';
                    if ($productStock == 0) {
                        echo '<p class="text-danger font-weight-bold mb-2">Out of Stock</p>';
                    } else {
                        echo '<p class="text-success mb-2">Stock: ' . $productStock . '</p>';
                    }
                    echo '</div>';

                    echo '<div class="button-section">';
                    if ($productStock == 0) {
                        echo '<button class="btn btn-secondary btn-block" disabled>Add to Cart</button>';
                    } else if ($loggedin) {
                        $quaSql = "SELECT `itemQuantity` FROM `viewcart` WHERE productId = '$productId' AND `userId`='$userId'";
                        $quaresult = mysqli_query($conn, $quaSql);
                        $quaExistRows = mysqli_num_rows($quaresult);
                        if ($quaExistRows == 0) {
                            echo '<form action="partials/_manageCart.php" method="POST" class="w-100">
                                    <input type="hidden" name="itemId" value="' . $productId . '">
                                    <button type="submit" name="addToCart" class="btn btn-primary btn-block">Add to Cart</button>
                                </form>';
                        } else {
                            echo '<a href="viewCart.php" class="w-100"><button class="btn btn-primary btn-block">Go to Cart</button></a>';
                        }
                    } else {
                        echo '<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#loginModal">Add to Cart</button>';
                    }
                    echo '<a href="viewProduct.php?productid=' . $productId . '" class="w-100"><button class="btn btn-primary btn-block">Quick View</button></a>
                        </div>
                    </div>
                </div>';
                }
                if ($noResult) {
                    echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">Sorry In this category No items available.</p>
                            <p class="lead"> We will update Soon.</p>
                        </div>
                    </div> ';
                }
                ?>
            </div>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
    <script>
        document.getElementById("title").innerHTML = "<?php echo $catname; ?>";
        document.getElementById("catTitle").innerHTML = "<?php echo $catname; ?>";
    </script>
</body>

</html>