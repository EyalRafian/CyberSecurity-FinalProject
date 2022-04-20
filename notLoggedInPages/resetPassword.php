<?php

include('../include/sessions.php');
include('../include/functions.php');

if (!isset($_SESSION['username'])) {
  $_SESSION["ErrorMessage"] = "Token was not provided please Try Again !";
  redirect('forgotPassword.php');
}
if (isset($_POST['Submit'])) {

  $historyAmount = json_decode(file_get_contents('passwords_policy.json'), true)['password_history'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  set_token($_SESSION['username'], NULL);

  // Get user from database
  $user = get_user($_SESSION['username']);
  if (!$user) {
    $_SESSION["ErrorMessage"] = "User Not Exsists";
    redirect('resetPassword.php');
  }

  // Check for empty fileds.
  if (empty($new_password) || empty($confirm_password)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    redirect('resetPassword.php');
  }
  // Check if new password and confirm password are match.
  else if ($new_password !== $confirm_password) {
    $_SESSION["ErrorMessage"] = "New Passwords not match !";
    redirect('resetPassword.php');
  }
  // Check for password policy.
  $new_password = password_policy($new_password);
  if (!$new_password) {
    redirect('resetPassword.php');
  }
  // Check if new password is in the user password history.
  elseif (check_password_history($new_password, $user["id"])) {
    $_SESSION["ErrorMessage"] = "You can't use your last " . $historyAmount . " passwords";
    redirect('resetPassword.php');
  } else {
    // Update the new password on the database.
    $success = update_new_password($new_password, $user["id"]);
    if ($success) {
      $_SESSION["SuccessMessage"] = "Password rest successfully";
      set_login_attempts($user["username"], NULL);
      redirect('../loggedInPages/signOut.php');
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
      redirect('resetPassword.php');
    }
  }
}


require_once("header.php");
?>

  <!-- Main Area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class=" col-lg-7 mx-auto" style="min-height:400px;">
        <br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="resetPassword.php" method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header" style="text-align: center;">
              <h1>Enter new password</h1>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="Password"> <span class="FieldInfo">New Password: </span></label>
                <input class="form-control" type="password" name="new_password" id="Password" value="">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword"> <span class="FieldInfo"> Confirm Password:</span></label>
                <input class="form-control" type="password" name="confirm_password" id="ConfirmPassword" value="">
              </div>
              <div class="col-lg-6 mb-2 mx-auto">
                <button type="submit" name="Submit" class="btn btn-success btn-block">Submit</button>
              </div>
            </div>
          </div>
      </div>
      </form>
    </div>
    </div>

  </section>



  <?php
require_once("footer.php");
?>