<?php
include 'partials/_dbconnect.php';
require 'partials/_nav.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="htmlcss bootstrap menu, navbar, mega menu examples" />
    <meta name="description" content="Bootstrap navbar examples for any type of project, Bootstrap 4" />

    <title>Profile </title>
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <style>
        body {
            background-color: #221b1b;
        }

        .row {
            margin-right: 150px;
            margin-top: 73px;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        #notfound {
            position: relative;
            height: 89vh;
            background-color: aliceblue;
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .notfound {
            max-width: 410px;
            width: 100%;
            text-align: center;
        }

        .notfound .notfound-404 {
            height: 280px;
            position: relative;
            z-index: -1;
        }

        .notfound .notfound-404 h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 230px;
            margin: 0px;
            font-weight: 900;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: url('img/bg.jpg') no-repeat;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: cover;
            background-position: center;
        }


        .notfound h2 {
            font-family: 'Montserrat', sans-serif;
            color: #000;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 0;
        }


        .notfound a {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            background: #0046d5;
            display: inline-block;
            padding: 15px 30px;
            border-radius: 40px;
            color: #fff;
            font-weight: 700;
            box-shadow: 0px 4px 15px -5px #0046d5;
        }


        @media only screen and (max-width: 767px) {
            .notfound .notfound-404 {
                height: 142px;
            }

            .notfound .notfound-404 h1 {
                font-size: 112px;
            }
        }

        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        button.btn.upload {
            border: 2px solid gray;
            background-color: #bababa;
            border-radius: 8px;
            font-size: 10px;
            font-weight: bold;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .profile-pic-wrapper {
            position: relative;
            width: 215px;
            height: 215px;
            margin: 0 auto;
        }

        .camera-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            cursor: pointer;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .camera-icon:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .camera-icon i {
            color: white;
            font-size: 18px;
        }

        #imageInput {
            display: none;
        }
    </style>
</head>

<body>

    <?php
    if ($loggedin) {
    ?>

        <div class="container">
            <?php
            $sql = "SELECT * FROM users WHERE id='$userId'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $email = $row['email'];
            $phone = $row['phone'];
            $userType = $row['userType'];
            $userImage = $row['image'];
            if ($userType == 0) {
                $userType = "User";
            } else {
                $userType = "Admin";
            }

            ?>
            <div class="row">
                <!-- Left Column - User Info -->
                <div class="col-md-4">
                    <div class="jumbotron p-3 mb-3" style="border-radius: 50px;">
                        <div class="user-info text-center">
                            <form action="partials/_manageProfile.php" method="POST" enctype="multipart/form-data">
                                <div class="profile-pic-wrapper">
                                    <img class="rounded-circle mb-3 bg-dark preview-image"
                                        src="<?php echo $userImage ? 'img/' . $userImage : 'img/profilePic.jpg'; ?>"
                                        style="width:100%;height:100%;padding:1px;object-fit:cover;">
                                    <label for="userimage-upload" class="camera-icon">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="userimage" id="userimage-upload" accept=".jpg" style="display:none;" onchange="previewImage(this)">
                                </div>

                                <ul class="meta list list-unstyled">
                                    <li class="username my-2"><a href="viewProfile.php">@<?php echo $username ?></a></li>
                                    <li class="name"><?php echo $firstName . " " . $lastName; ?>
                                        <label class="label label-info">(<?php echo $userType ?>)</label>
                                    </li>
                                    <li class="email"><?php echo $email ?></li>
                                    <li class="my-2"><a href="partials/_logout.php"><button class="btn btn-secondary" style="font-size: 15px;padding: 3px 8px;">Logout</button></a></li>
                                </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="col-md-8">
                    <div class="content-panel p-4" style="background-color: aliceblue; border-radius: 1.1rem;">
                        <h2 class="title text-center mb-4">Edit Profile</h2>
                        <form action="partials/_manageProfile.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <b><label for="username-edit">Username:</label></b>
                                <input class="form-control" id="username-edit" name="username" type="text" disabled value="<?php echo $username ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <b><label for="firstName-edit">First Name:</label></b>
                                    <input type="text" class="form-control" id="firstName-edit" name="firstName" placeholder="First Name" required value="<?php echo $firstName ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <b><label for="lastName-edit">Last Name:</label></b>
                                    <input type="text" class="form-control" id="lastName-edit" name="lastName" placeholder="Last name" required value="<?php echo $lastName ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <b><label for="email-edit">Email:</label></b>
                                <input type="email" class="form-control" id="email-edit" name="email" placeholder="Enter Your Email" required value="<?php echo $email ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <b><label for="phone-edit">Phone No:</label></b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon">+63</span>
                                        </div>
                                        <input type="tel" class="form-control" id="phone-edit" name="phone" placeholder="Enter Your Phone Number" required pattern="[0-9]{10}" maxlength="10" value="<?php echo $phone ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <b><label for="address-edit">Street Address:</label></b>
                                <input type="text" class="form-control" id="address-edit" name="address" placeholder="Enter Your Street Address" required value="<?php echo $row['address'] ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <b><label for="city-edit">City:</label></b>
                                    <input type="text" class="form-control" id="city-edit" name="city" placeholder="Enter Your City" required value="<?php echo $row['city'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <b><label for="zipcode-edit">ZIP Code:</label></b>
                                    <input type="text" class="form-control" id="zipcode-edit" name="zipcode" placeholder="Enter ZIP Code" required pattern="[0-9]{4}" maxlength="4" value="<?php echo $row['zipcode'] ?>">
                                </div>
                            </div>
                            <button type="submit" name="updateProfileDetail" class="btn btn-primary btn-block">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo '<div id="notfound">
                    <div class="notfound-404">
                        <h1>Oops!</h1>
                    </div>
                    <h2>404 - Page not found</h2>
                    <a href="index.php">Go To Homepage</a>
                </div>';
    }
    ?>
    <?php require 'partials/_footer.php' ?>

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Then Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

    <!-- Finally other plugins that depend on jQuery and Bootstrap -->
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>