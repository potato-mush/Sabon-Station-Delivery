<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title>Home</title>
    <link rel = "icon" href ="img/logo.jpg" type = "image/x-icon">
  </head>
<body>
  <?php include 'partials/_dbconnect.php';?>
  <?php require 'partials/_nav.php' ?>
  
  <!-- Category container starts here -->
  <div class="container my-3 mb-5">
    <div class="col-lg-2 text-center bg-light my-3" style="margin:auto;border-top: 2px groove black;border-bottom: 2px groove black;">     
      <h2 class="text-center">Categories</h2>
    </div>
    <div class="row">
      <!-- Fetch all the categories and use a loop to iterate through categories -->
      <?php 
        $sql = "SELECT * FROM `categories`"; 
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          $id = $row['categorieId'];
          $cat = $row['categorieName'];
          $desc = $row['categorieDesc'];
          $image = $row['image']; // Use correct column name
          echo '<div class="col-xs-3 col-sm-3 col-md-3">
                  <div class="card" style="width: 18rem;">
                    <img src="img/' . $image . '" class="card-img-top" alt="' . $cat . '" width="249px" height="270px">
                    <div class="card-body">
                      <h5 class="card-title"><a href="viewProductList.php?catid=' . $id . '">' . $cat . '</a></h5>
                      <p class="card-text">' . substr($desc, 0, 30). '... </p>
                      <a href="viewProductList.php?catid=' . $id . '" class="btn btn-primary">View All</a>
                    </div>
                  </div>
                </div>';
        }
      ?>
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
        function fetchNotifications() {
            $.ajax({
                url: 'partials/fetch_notifications.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    const notificationList = $('#notificationList');
                    notificationList.empty();
                    
                    if(data.unreadCount > 0) {
                        $('#notificationCount').text(data.unreadCount);
                    } else {
                        $('#notificationCount').text('');
                    }
                    
                    data.notifications.forEach(notification => {
                        notificationList.append(`
                            <div class="dropdown-item">
                                <small class="text-muted">${notification.timestamp}</small>
                                <p class="mb-0">${notification.message}</p>
                            </div>
                            <div class="dropdown-divider"></div>
                        `);
                    });
                }
            });
        }

        // Fetch notifications every 30 seconds
        $(document).ready(function() {
            fetchNotifications();
            setInterval(fetchNotifications, 30000);
            
            $('#notification').click(function() {
                $.post('partials/fetch_notifications.php', {markRead: true});
                $('#notificationCount').text('');
            });
        });
    </script>
    <script>
        function fetchNotifications() {
            $.ajax({
                url: 'partials/fetch_notifications.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data.error) {
                        return;
                    }
                    
                    const notificationList = $('#notificationList');
                    notificationList.empty();
                    
                    // Update notification count
                    if(data.unreadCount > 0) {
                        $('#notificationCount').text(data.unreadCount).show();
                    } else {
                        $('#notificationCount').text('').hide();
                    }
                    
                    // Update notification list
                    if(data.notifications.length === 0) {
                        notificationList.append('<div class="dropdown-item text-center">No notifications</div>');
                    } else {
                        data.notifications.forEach(notification => {
                            const notificationClass = notification.status == 0 ? 'bg-light' : '';
                            notificationList.append(`
                                <div class="dropdown-item ${notificationClass}">
                                    <small class="text-muted d-block">${notification.timestamp}</small>
                                    <p class="mb-0">${notification.message}</p>
                                </div>
                                <div class="dropdown-divider"></div>
                            `);
                        });
                    }
                },
                error: function() {
                    console.log('Error fetching notifications');
                }
            });
        }

        $(document).ready(function() {
            // Initial fetch
            fetchNotifications();
            
            // Fetch every 10 seconds
            setInterval(fetchNotifications, 10000);
            
            // Mark as read when dropdown is opened
            $('#notification').on('show.bs.dropdown', function() {
                $.ajax({
                    url: 'partials/fetch_notifications.php',
                    type: 'POST',
                    data: {markRead: true},
                    success: function() {
                        fetchNotifications();
                    }
                });
            });
        });
    </script>
</body>
</html>