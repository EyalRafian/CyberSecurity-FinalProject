<?php

include('../include/functions.php');
include('../include/sessions.php');

if (isset($_POST["Submit"])) {
  $token = $_POST["Token"];
  if (empty($token)) {
    $_SESSION["ErrorMessage"] = "Please Enter The token you got on your mail";
    redirect('enterToken.php');
  } else {
    $username = check_token($token);
    if ($username) {
      $_SESSION["username"] = $username;
      redirect('./resetPassword.php');
    } else {
      $_SESSION["ErrorMessage"] = "Invalid Token !";
      redirect("enterToken.php");
    }
  }
}

require_once("header.php");
?>
  <!-- Main Area Start -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class=" col-lg-6 mx-auto" style="min-height:400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="enterToken.php" method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header" style="text-align: center;">
              <h1>Enter Token</h1>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="token"> <span class="FieldInfo"> Token: </span></label>
                <input class="form-control" type="text" name="Token" id="token" value="">
              </div>
              <div class="row">
                <div class="col-lg-8 mb-2 mx-auto">
                  <button type="submit" name="Submit" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Submit
                  </button>
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