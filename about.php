<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <title>About Us</title>
    <link rel = "icon" href ="img/logo.jpg" type = "image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

  </head>
  <body>
  <?php include 'partials/_dbconnect.php';?>
  <?php include 'partials/_nav.php';?>
  
      <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="carousel-background"><img src="assets/img/slide/slide-1.jpg" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Sabon Station</span></h2>
                <a href="index.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Get Started</a>
              </div>
            </div>
          </div>
          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="carousel-background"><img src="assets/img/slide/slide-2.jpg" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown mb-0">Our Mission</h2>
                <p class="animate__animated animate__fadeInUp">We are committed in building a long-term relationship with our partners and customers by bringing the best quality and affordable household cleaning and home care products to the heart of Filipino communities.</p>
                <a href="index.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Get Started</a>
              </div>
            </div>
          </div>
          <!-- Slide 3 -->
          <div class="carousel-item">
            <div class="carousel-background"><img src="assets/img/slide/slide-3.jpg" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
              <h2 class="animate__animated animate__fadeInDown mb-0">Our Vision</h2>
              <p class="animate__animated animate__fadeInUp">We are continuously improving to be recognized as the country’s leading and most trusted local manufacturer of household cleaning and home care products.</p>
              <a href="index.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Get Started</a>
              </div>
            </div>
          </div>
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon icofont-thin-double-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon icofont-thin-double-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About Us</h2>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="about-img">
              <img src="img/about-image.jpg" class="img-fluid rounded" alt="About Sabon Station">
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content">
            <h3>Sabon Station: Creating Clean Spaces and Happy Homes</h3>
            <p class="font-italic">
              Since our establishment, Sabon Station has been a cornerstone in providing premium quality household cleaning and care products across the Philippines.
            </p>
            <p>
              At Sabon Station, we understand that a clean home is a happy home. Our products are carefully formulated to deliver optimal cleaning power while remaining gentle on surfaces and fabrics. We combine traditional cleaning wisdom with modern innovation to create solutions that truly work.
            </p>
            
            <div class="row mt-4">
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="icofont-check-circled"></i>
                  <h4>Quality First</h4>
                  <p>We never compromise on the quality of our ingredients and formulations</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="icofont-earth"></i>
                  <h4>Eco-Friendly</h4>
                  <p>Committed to sustainable practices and environmentally conscious products</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="icofont-heart"></i>
                  <h4>Customer-Centric</h4>
                  <p>Designed with Filipino families' needs and preferences in mind</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="icofont-award"></i>
                  <h4>Value for Money</h4>
                  <p>Premium quality products at prices that won't break your budget</p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Counts Section ======= -->
    <section class="counts section-bg">
      <div class="container">

        <div class="row no-gutters">
          <?php 
            // Get happy customers (unique users who ordered)
            $sql = "SELECT COUNT(DISTINCT userId) as customer_count FROM orders";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $customerCount = $row['customer_count'];
            
            // Get number of products
            $sql = "SELECT COUNT(*) as product_count FROM products";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $productCount = $row['product_count'];
            
            // Get number of fulfilled orders (status 4 = delivered)
            $sql = "SELECT COUNT(*) as order_count FROM orders WHERE orderStatus='4'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $orderCount = $row['order_count'];
            
            // For team members, we'll use a hardcoded value since it's likely not in DB
            $teamCount = 3;
          ?>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-simple-smile"></i>
              <span data-toggle="counter-up"><?php echo $customerCount; ?></span>
              <p><strong>Happy Customers</strong></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-document-folder"></i>
              <span data-toggle="counter-up"><?php echo $productCount; ?></span>
              <p><strong>Products</strong></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-delivery-time"></i>
              <span data-toggle="counter-up"><?php echo $orderCount; ?></span>
              <p><strong>Orders Fulfilled</strong></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-users-alt-5"></i>
              <span data-toggle="counter-up"><?php echo $teamCount; ?></span>
              <p><strong>Team Members</strong></p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

  </main>

  <?php include 'partials/_footer.php';?> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>         
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-sticky/jquery.sticky.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counterup/counterup.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>


  </body>
</html>
