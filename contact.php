<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    
    <title>Contact Us</title>
    <link rel = "icon" href ="img/logo.jpg" type = "image/x-icon">
    <style>
       .icon-badge-group .icon-badge-container {
          display: inline-block;
        
        }
        .icon-badge-container {
          
          position: absolute;
        }
        .icon-badge-icon {
          font-size: 30px;
          color: rgb(0 0 0 / 50%);
          position: relative;
        }
        .icon-badge {
          background-color: #979797;;
          font-size: 10px;
          color: white;
          text-align: center;
          width: 15px;
          height: 15px;
          border-radius: 49%;
          position: relative;
          top: -35px;
          left: 17px;
        }
      .footer.container-fluid.bg-dark.text-light {
          position:fixed;
          bottom:0;
      }
      .contact2 {
        font-family: "Montserrat", sans-serif;
        color: #8d97ad;
        font-weight: 300;
        /* padding: 60px 0; */
        /* margin-bottom: 170px; */
        background-position: center top;
      }

      .contact2 h1,
      .contact2 h2,
      .contact2 h3,
      .contact2 h4,
      .contact2 h5,
      .contact2 h6 {
        color: #3e4555;
      }

      .contact2 .font-weight-medium {
        font-weight: 500;
      }

      .contact2 .subtitle {
        color: #8d97ad;
        line-height: 24px;
      }

      .contact2 .bg-image {
        background-size: cover;
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
      }

      .contact2 .card.card-shadow {
          -webkit-box-shadow: 0px 0px 30px rgba(115, 128, 157, 0.1);
          box-shadow: 0px 0px 30px rgba(61, 109, 214, 0.774);
      }

      .contact2 .detail-box .round-social {
        margin-top: 100px;
      }

      .contact2 .round-social a {
        background: transparent;
        margin: 0 7px;
        padding: 11px 12px;
      }

      .contact2 .contact-container .links a {
        color: #8d97ad;
      }

      .contact2 .contact-container {
        position: relative;
        top: 107px;
      }

      .contact2 .btn-danger-gradiant {
        background: #ff4d7e;
        background: -webkit-linear-gradient(legacy-direction(to right), #ff4d7e 0%, #ff6a5b 100%);
        background: -webkit-gradient(linear, left top, right top, from(#ff4d7e), to(#ff6a5b));
        background: -webkit-linear-gradient(left, #ff4d7e 0%, #ff6a5b 100%);
        background: -o-linear-gradient(left, #ff4d7e 0%, #ff6a5b 100%);
        background: linear-gradient(to right, #ff4d7e 0%, #ff6a5b 100%);
      }

      .contact2 .btn-danger-gradiant:hover {
        background: #ff6a5b;
        background: -webkit-linear-gradient(legacy-direction(to right), #ff6a5b 0%, #ff4d7e 100%);
        background: -webkit-gradient(linear, left top, right top, from(#ff6a5b), to(#ff4d7e));
        background: -webkit-linear-gradient(left, #ff6a5b 0%, #ff4d7e 100%);
        background: -o-linear-gradient(left, #ff6a5b 0%, #ff4d7e 100%);
        background: linear-gradient(to right, #ff6a5b 0%, #ff4d7e 100%);
      }
    </style>
  </head>
  <body>
  <?php include 'partials/_dbconnect.php';?>
  <?php include 'partials/_nav.php';?>

      <div class="contact2" style="background-image:url(img/map.jpg);height: 400px;" id="contact">
        <div class="container">
          <div class="row contact-container">
            <div class="col-lg-12">
              <div class="card card-shadow border-0 mb-4">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="contact-box p-4">
                      <div class="row">
                        <div class="col-lg-8">
                          <h4 class="title">Contact Us</h4>
                        </div>
                        <?php if($loggedin){ ?>
                          <div class="col-lg-4">
                            <div class="icon-badge-container mx-1" style="padding-left: 167px;">
                              <a href="#" data-toggle="modal" data-target="#adminReply"><i class="far fa-envelope icon-badge-icon"></i></a>
                              <div class="icon-badge"><b><span id="totalMessage">0</span></b></div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                      <?php
                          $email = "";
                          $phone = "";
                          if($loggedin) {
                              $passSql = "SELECT * FROM users WHERE id='$userId'"; 
                              $passResult = mysqli_query($conn, $passSql);
                              $passRow=mysqli_fetch_assoc($passResult);
                              $email = $passRow['email'];
                              $phone = $passRow['phone'];
                          }
                      ?>
                      <form action="partials/_manageContactUs.php" method="POST">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group mt-3">
                                <b><label for="email">Email:</label></b>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required value="<?php echo $email ?>">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group mt-3">
                                <b><label for="phone">Phone No:</label></b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon">+63</span>
                                    </div>
                                    <input type="tel" class="form-control" id="phone" name="phone" aria-describedby="basic-addon" placeholder="Enter Your Phone Number" required pattern="[0-9]{10}" value="<?php echo $phone ?>">
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group mt-3">
                              <b><label for="orderId">Order Id:</label></b>
                              <input class="form-control" type="text" id="orderId" name="orderId" placeholder="Order Id" value="0">
                              <small id="orderIdHelp" class="form-text text-muted">If your problem is not related to the order(order id = 0).</small>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group mt-3">
                              <b><label for="password">Password:</label></b>
                              <input class="form-control" id="password" name="password" placeholder="Enter Password" type="password" placeholder="Enter Your Password" required data-toggle="password">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group  mt-3">
                                <textarea class="form-control" id="message" name="message" rows="2" required minlength="6" placeholder="How May We Help You ?"></textarea>
                            </div>
                          </div>
                          <?php if($loggedin){ ?>
                            <div class="col-lg-12">
                              <button type="submit" class="btn btn-danger-gradiant mt-3 mb-3 text-white border-0 py-2 px-3"><span> SUBMIT NOW <i class="ti-arrow-right"></i></span></button>
                              <button type="button" class="btn btn-danger-gradiant mt-3 mb-3 text-white border-0 py-2 px-3 mx-2" data-toggle="modal" data-target="#history"><span> HISTORY <i class="ti-arrow-right"></i></span></button>
                            </div>
                          <?php }else { ?>
                            <div class="col-lg-12">
                              <button type="submit" class="btn btn-danger-gradiant mt-3 text-white border-0 py-2 px-3" disabled><span> SUBMIT NOW <i class="ti-arrow-right"></i></span></button>
                              <small class="form-text text-muted">First login to Contct with Us.</small>
                            </div>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                  <?php
                    $sql = "SELECT * FROM `sitedetail`";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    $systemName = $row['systemName'];
                    $address = $row['address'];
                    $email = $row['email'];
                    $contact1 = $row['contact1'];
                    $contact2 = $row['contact2'];

                    echo '<div class="col-lg-4 bg-image" style="background-image:url(img/contact.jpg)">
                          <div class="detail-box p-4">
                            <h5 class="text-white font-weight-light mb-3">ADDRESS</h5>
                            <p class="text-white op-7">' .$address. '</p>
                            <h5 class="text-white font-weight-light mb-3 mt-4">CALL US</h5>
                            <p class="text-white op-7">' .$contact1. '
                              <br> ' .$contact2. '</p>
                            <div class="round-social light">
                              <a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=' .$email. '" class="ml-0 text-decoration-none text-white border border-white rounded-circle" target="_blank"><i class="far fa-envelope"></i></a>
                              <a href="https://www.facebook.com/people/Sabon-Station-Malasiqui-Pangasinan-Boss-G/100064348591769/" class="text-decoration-none text-white border border-white rounded-circle" target="_blank"><i class="fab fa-facebook"></i></i></a>
                              <a href="https://maps.app.goo.gl/j7wfqMzVHHtUAjj88" class="text-decoration-none text-white border border-white rounded-circle" target="_blank"><i class="fas fa-map-marker-alt"></i></a>
                            </div>
                          </div>
                        </div>';
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Message Modal -->
      <div class="modal fade" id="adminReply" tabindex="-1" role="dialog" aria-labelledby="adminReply" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(187 188 189);">
              <h5 class="modal-title" id="adminReply">Admin Reply</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="messagebd">
              <table class="table-striped table-bordered col-md-12 text-center">
                <thead style="background-color: rgb(111 202 203);">
                    <tr>
                        <th>Contact Id</th>
                        <th>Reply Message</th>
                        <th>datetime</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sql = "SELECT * FROM `contactreply` WHERE `userId`='$userId'"; 
                    $result = mysqli_query($conn, $sql);
                    $count = 0;
                    while($row=mysqli_fetch_assoc($result)) {
                        $contactId = $row['contactId'];
                        $message = $row['message'];
                        $datetime = $row['datetime'];
                        $count++;
                        echo '<tr>
                                <td>' .$contactId. '</td>
                                <td>' .$message. '</td>
                                <td>' .$datetime. '</td>
                              </tr>';
                    }
                    echo '<script>document.getElementById("totalMessage").innerHTML = "' .$count. '";</script>';
                    if($count==0) {
                      ?><script> document.getElementById("messagebd").innerHTML = '<div class="my-1">you have not recieve any message.</div>';</script> <?php
                    }
                ?>
                </tbody>
		          </table>
            </div>
          </div>
        </div>
      </div>

      <!-- history Modal -->
      <div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="history" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(187 188 189);">
              <h5 class="modal-title" id="history">Your Sent Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="bd">
              <table class="table-striped table-bordered col-md-12 text-center">
                <thead style="background-color: rgb(111 202 203);">
                    <tr>
                        <th>Contact Id</th>
                        <th>Order Id</th>
                        <th>Message</th>
                        <th>datetime</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sql = "SELECT * FROM `contact` WHERE `userId`='$userId'"; 
                    $result = mysqli_query($conn, $sql);
                    $count = 0;
                    while($row=mysqli_fetch_assoc($result)) {
                        $contactId = $row['contactId'];
                        $orderId = $row['orderId'];
                        $message = $row['message'];
                        $datetime = $row['time'];
                        $count++;
                        echo '<tr>
                                <td>' .$contactId. '</td>
                                <td>' .$orderId. '</td>
                                <td>' .$message. '</td>
                                <td>' .$datetime. '</td>
                              </tr>';
                    }                
                    if($count==0) {
                      ?><script> document.getElementById("bd").innerHTML = '<div class="my-1">you have not contacted us.</div>';</script> <?php
                    }    
                ?>
                </tbody>
		          </table>
            </div>
          </div>
        </div>
      </div>


  <?php include 'partials/_footer.php';?> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>         
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
      <!-- Chat Support Script -->
  <script>
    (function() {
      const chatWidget = document.createElement("div");
      chatWidget.id = "chat-widget";
      Object.assign(chatWidget.style, {
        position: "fixed",
        bottom: "20px",
        right: "20px",
        width: "350px",
        height: "520px",
        border: "1px solid #ccc",
        borderRadius: "10px",
        boxShadow: "0 0 10px rgba(0,0,0,0.1)",
        backgroundColor: "#fff",
        display: "none",
        fontFamily: "Arial, sans-serif",
      });
      chatWidget.innerHTML = `
      <div style="padding: 10px; background-color: #007bff; color: #fff; border-radius: 10px 10px 0 0;">
        Customer Support
        <button id="close-chat" style="float: right; background: none; border: none; color: #fff; font-size: 18px;">&times;</button>
      </div>
      <div id="chat-content" style="padding: 10px; height: 400px; overflow-y: auto;"></div>
      <div style="padding: 10px; border-top: 1px solid #ccc; display: flex;">
        <input type="text" id="chat-input" placeholder="Type a message..." style="flex-grow: 1; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        <button id="send-button" style="margin-left: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px;">Send</button>
      </div>
    `;
      document.body.appendChild(chatWidget);

      const chatTrigger = document.createElement("button");
      chatTrigger.id = "chat-trigger";
      Object.assign(chatTrigger.style, {
        position: "fixed",
        bottom: "20px",
        right: "20px",
        width: "50px",
        height: "50px",
        borderRadius: "50%",
        backgroundColor: "#007bff",
        color: "#fff",
        border: "none",
        fontSize: "20px",
        cursor: "pointer",
        boxShadow: "0 0 10px rgba(0,0,0,0.1)",
      });
      chatTrigger.innerHTML = "💬";
      document.body.appendChild(chatTrigger);

      const chatInput = document.getElementById("chat-input");
      const chatContent = document.getElementById("chat-content");
      const closeChat = document.getElementById("close-chat");
      const sendButton = document.getElementById("send-button");

      chatTrigger.addEventListener("click", () => {
        chatWidget.style.display = "block";
        chatTrigger.style.display = "none";
      });

      closeChat.addEventListener("click", () => {
        chatWidget.style.display = "none";
        chatTrigger.style.display = "block";
      });

      function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        chatContent.innerHTML += `<div style='text-align: right;'><span style='background-color: #007bff; color: #fff; padding: 5px 10px; margin: 15px 4px; border-radius: 10px; display: inline-block; max-width: 80%; word-wrap: break-word;'>${message}</span></div>`;
        chatInput.value = "";
        chatContent.scrollTop = chatContent.scrollHeight;

        // Add typing indicator
        const typingIndicatorId = 'typing-' + Date.now();
        chatContent.innerHTML += `<div id="${typingIndicatorId}" style='text-align: left;'><span style='background-color: #f1f1f1; padding: 5px 10px; margin: 15px 4px; border-radius: 10px; display: inline-block;'>Typing...</span></div>`;
        chatContent.scrollTop = chatContent.scrollHeight;

        fetch("chat.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              message
            })
          })
          .then(res => {
            if (!res.ok) {
              throw new Error(`HTTP error! Status: ${res.status}`);
            }
            return res.json();
          })
          .then(data => {
            // Remove typing indicator
            document.getElementById(typingIndicatorId).remove();
            
            if (data.error) {
              chatContent.innerHTML += `<div style='text-align: left;'><span style='background-color: #f1f1f1; padding: 5px 10px; border-radius: 10px; color: red; display: inline-block; max-width: 80%; word-wrap: break-word;'>Error: ${data.error}</span></div>`;
            } else {
              // Create a container for the HTML content
              const responseContainer = document.createElement('div');
              responseContainer.style.textAlign = 'left';
              
              const responseSpan = document.createElement('span');
              responseSpan.style.backgroundColor = '#f1f1f1';
              responseSpan.style.padding = '5px 10px';
              responseSpan.style.borderRadius = '10px';
              responseSpan.style.display = 'inline-block';
              responseSpan.style.maxWidth = '80%';
              responseSpan.style.wordWrap = 'break-word';
              
              // Set HTML content safely
              responseSpan.innerHTML = data.reply;
              
              // Add click event listeners to all links
              responseContainer.appendChild(responseSpan);
              chatContent.appendChild(responseContainer);
              
              // Add click handlers to all links
              const links = responseSpan.querySelectorAll('a');
              links.forEach(link => {
                link.style.color = '#007bff';
                link.style.textDecoration = 'underline';
                link.addEventListener('click', function(event) {
                  event.preventDefault();
                  window.location.href = this.getAttribute('href');
                });
              });
            }
            chatContent.scrollTop = chatContent.scrollHeight;
          })
          .catch((error) => {
            // Remove typing indicator
            document.getElementById(typingIndicatorId).remove();
            
            console.error('Error:', error);
            chatContent.innerHTML += `<div style='text-align: left;'><span style='background-color: #f1f1f1; padding: 5px 10px; border-radius: 10px; color: red; display: inline-block; max-width: 80%; word-wrap: break-word;'>Error: Unable to connect</span></div>`;
            chatContent.scrollTop = chatContent.scrollHeight;
          });
      }

      sendButton.addEventListener("click", sendMessage);
      chatInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
      });
    })();
  </script>
  </body>
</html>