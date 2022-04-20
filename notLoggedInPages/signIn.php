<?php
include('../include/sessions.php');
include('../include/functions.php');
include('../include/dbConfig.php');

// Check if user already logged in
if (isset($_SESSION['userId'])) {
  redirect('../loggedInPages/dashboard.php');
}

if (isset($_POST['Submit'])) {

  $loginAllow = json_decode(file_get_contents('../passwords_policy.json'), true)['login_attempts'];
  $userName = $_POST['Username'];
  $password = $_POST['Password'];

  // Check all fileds are filled
  if (empty($userName) || empty($password)) {
    $_SESSION['ErrorMessage'] = "All fields must be filled out";
    redirect('signIn.php');
  }

  // Query the db for username and his login attempts, if user exists return a user object.
  $user = get_login_attempts($userName);
  if ($user) {
    $attempts = $user['login_attempts'] + 1;

    // If max attempt exceeded prevent login and redirect to rest password page.
    if ($attempts > $loginAllow) {
      $_SESSION["ErrorMessage"] = "Your account is block please reset password";
      redirect("./forgotPassword.php");
    } else {

      // Validate username and password from the database.
      $account = authenticate($userName, $password);
      if ($account) {

        // If authentication was OK set all session variables and set login attempts to 0.
        $_SESSION["userId"] = $account["id"];
        $_SESSION["userName"] = $account["username"];
        $_SESSION["email"] = $account["email"];
        $_SESSION["SuccessMessage"] = "Wellcome " . $_SESSION["userName"] . "!";
        set_login_attempts($userName, 0);

        // After successfull login redirect the user to previous page if set or to dashboard.
        if (isset($_SESSION['TrackingURL'])) {
          redirect($_SESSION['TrackingURL']);
        } else {
          redirect('../loggedInPages/dashboard.php');
        }
      } else {
        // If password was wrong , increate login attempts and display message , redirect to login page.
        set_login_attempts($userName, $attempts);
        $_SESSION["ErrorMessage"] = "Wrong Password you have another " . ($loginAllow - $attempts) . " attempts";
        redirect("./signIn.php");
      }
    }
  } else {
    $_SESSION["ErrorMessage"] = "User Not Exists";
    redirect("./signIn.php");
  }
}

require_once("header.php");
?>

  <!-- Main Area Start -->
  <section class="container-fluid ml-5 mt-1 mr-2">
    <div class="row">
      <div class=" col-lg-4" style="min-height:400px;">
        <br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="signIn.php" method="post">
          <div class="card text-light mb-3" style="background-color: #90a4ae;">
            <div class=" card-header" style="text-align: center;">
              <h1>Sign In</h1>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="username"> <span class="FieldInfo"> Username: </span></label>
                <input class="form-control" type="text" name="Username" id="username" value="">
              </div>
              <div class="form-group">
                <label for="Password"> <span class="FieldInfo"> Password: </span></label>
                <input class="form-control" type="password" name="Password" id="Password" value="">
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-primary btn-block">
                    <i class="fas fa-check"></i> Login
                  </button>
                </div>
                <div class="col-lg-6 mb-2">
                  <a href="forgotPassword.php" class="btn btn-danger btn-block">Forgot Password</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="col-lg-8">
        <?php include("signUp.php"); ?>
      </div>
    </div>

  </section>

  <!-- Main Area End -->



  <?php
require_once("footer.php");
?>