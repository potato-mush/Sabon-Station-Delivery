<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: rgb(111 202 203);">
            <h5 class="modal-title" id="loginModal">Login Here</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="partials/_handleLogin.php" method="post">
              <div class="form-group">
                  <b><label for="loginUsername">Username</label></b>
                  <input class="form-control" id="loginUsername" name="loginUsername" placeholder="Enter Your Username" type="text" required>
              </div>
              <div class="form-group">
                  <b><label for="loginPassword">Password</label></b>
                  <input class="form-control" id="loginPassword" name="loginPassword" placeholder="Enter Password" type="password" required data-toggle="password">
              </div>
              <button type="submit" class="btn btn-success">Submit</button>
            </form>
            <p class="mb-0 mt-1">Don't have an account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signupModal">Sign up now</a>.</p>
          </div>
        </div>
      </div>
    </div>

