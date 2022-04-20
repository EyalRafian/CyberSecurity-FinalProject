<?php

include('../include/functions.php');
include('../include/sessions.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
is_authenticated();

if (isset($_POST['Submit'])) {
  $historyAmount = json_decode(file_get_contents('../passwords_policy.json'), true)['password_history'];
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // Get user from database
  $user = get_user($_SESSION['userName']);

  // Check for empty fileds.
  if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    redirect('changePassword.php');
  }
  // Check if the old password is correct.
  else if ($user["password"] != hash_password($old_password)) {
    $_SESSION["ErrorMessage"] = "Wrong Password , try again !";
    redirect('changePassword.php');
  }
  // Check if new password and confirm password are match.
  else if ($new_password !== $confirm_password) {
    $_SESSION["ErrorMessage"] = "New Passwords not match !";
    redirect('changePassword.php');
  }
  
  // Check for password policy.
  $new_password = password_policy($new_password);
  if (!$new_password) {
    redirect('changePassword.php');
  }
  // Check if new password is in the user password history.
  elseif (check_password_history($new_password, $user["id"])) {
    $_SESSION["ErrorMessage"] = "You can't use your last " . $historyAmount . " passwords";
    redirect("changePassword.php");
  } else {
    // Update the new password on the database.
    $success = update_new_password($new_password, $user["id"]);
    if ($success) {
      $_SESSION["SuccessMessage"] = "Password rest successfull";
      redirect('dashboard.php');
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
      redirect("changePassword.php");
    }
  }
}

require_once('header.php');
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
      <form class="" action="changePassword.php" method="post">
        <div class="card bg-secondary text-light mb-3">
          <div class="card-header" style="text-align:center;">
            <h1>Change Password</h1>
          </div>

          <div class="card-body">
            <div class="form-group">
              <label for="Password"> <span class="FieldInfo">Old Password: </span></label>
              <input class="form-control" type="password" name="old_password" id="Password" value="">
            </div>

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
      </form>
    </div>

    <div class="jumbotron col-lg-5 mt-5">
      <p style="font-weight: bold;">
      <ul style="color: red; font-weight: bold;">
        <li>atleast 10 characters</li>
        <li>a minimum of 1 lower case letter [a-z]</li>
        <li>a minimum of 1 upper case letter [A-Z]</li>
        <li>a minimum of 1 numeric character [0-9]</li>
        <li>a minimum of 1 special character: ~`!@#$%^&*()-_+={}[]|\;:"<>,./?</li>
        <li>password can't be one of your 3 last passwords</li>
        <li>common passwords are not acceptable</li>
      </ul>
      </p>
    </div>

  </div>

</section>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>