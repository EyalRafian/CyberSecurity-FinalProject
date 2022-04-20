<?php
include('../include/functions.php');
include('../include/sessions.php');

if (isset($_POST["Submit"])) {
  $userName = $_POST['Username'];

  if (empty($userName)) {
    $_SESSION["ErrorMessage"] = "Please Enter User name";
    redirect('forgotPassword.php');
  } else if (!get_user($userName)) {
    $_SESSION["ErrorMessage"] = "User not exists";
    redirect('forgotPassword.php');
  } else {
    $_SESSION['Token'] = null;
    $success = send_token($userName);
    if ($success) {
      $_SESSION["SuccessMessage"] = "A token for changing password was sent to your email !";
      redirect('./enterToken.php');
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
      redirect("forgotPassword.php");
    }
  }
}

require_once("header.php");
?>

  <!-- Main Area Start -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class=" col-lg-7 mx-auto" style="min-height:400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="forgotPassword.php" method="post">
          <div class="card text-light mb-3" style="background-color: #90a4ae;">
            <div class="card-header" style="text-align: center;">
              <h1>Reset Password</h1>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="username"> <span class="FieldInfo"> User Name: </span></label>
                <input class="form-control" type="text" name="Username" id="username" value="">
              </div>
              <div class="row">

                <div class="col-lg-6 mb-2">

                  <button type="submit" name="Submit" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Reset
                  </button>
                </div>

                <div class="col-lg-6 mb-2">
                  <a href="signIn.php" class="btn btn-primary btn-block">Login</a>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </section>

  <!-- Main Area End -->


  <?php
require_once("footer.php");
?>