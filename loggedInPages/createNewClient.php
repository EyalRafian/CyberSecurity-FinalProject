<?php

include('../include/functions.php');
include('../include/sessions.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
is_authenticated();

if (isset($_POST['Submit'])) {
  $firstName = $_POST['firstName'];
  $lastName =  $_POST['lastName'];
  $id =  $_POST['id'];
  $phoneNumber =  $_POST['phoneNumber'];
  $address =  $_POST['address'];
  $dealPackage =  $_POST['dealPackage'];
  $sector =  $_POST['sector'];

  //Check for empty fileds.
  if (empty($firstName) || empty($lastName) || empty($id) || empty($phoneNumber) || empty($address) || empty($dealPackage) || empty($sector)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    redirect('createNewClient.php');
  }
  // Check if client exsists on the database.
  else if (get_client($firstName, $lastName)) {
    $_SESSION["ErrorMessage"] = "Client already exists !";
    redirect('createNewClient.php');
  } else {
    // Create new client.
    $clientId = create_new_client($firstName, $lastName, $id, $phoneNumber, $address, $dealPackage, $sector);
    if ($clientId) {
      $_SESSION["SuccessMessage"] = "New client created !";
      redirect('dashboard.php');
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
      redirect("createNewClient.php");
    }
  }
}

require_once('header.php')
?>

<!-- Main Area -->
<section class="container py-2 mb-4" style="margin-left: auto; margin-right: auto;">
  <div class="row">
    <div class="col-md-7 mx-auto" style="min-height:400px;">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
      <form class="" action="createNewClient.php" method="post">
        <div class="card bg-secondary text-light mb-3">

          <div class="card-header" style="text-align: center;">
            <h1>Add New Client</h1>
          </div>

          <div class="card-body" style="color: red;">
            <div class=" form-group">
              <label for="firstname"> <span class="FieldInfo"> First Name </span></label>
              <input class="form-control" type="text" name="firstName" id="firstname" value="">
            </div>

            <div class="form-group">
              <label for="lastname"> <span class="FieldInfo"> Last Name: </span></label>
              <input class="form-control" type="text" name="lastName" id="lastname" value="">
            </div>

            <div class="form-group">
              <label for="firstname"> <span class="FieldInfo"> ID </span></label>
              <input class="form-control" type="text" name="id" id="id" value="">
            </div>

            <div class="form-group">
              <label for="firstname"> <span class="FieldInfo"> Phone Number </span></label>
              <input class="form-control" type="text" name="phoneNumber" id="phoneNumber" value="">
            </div>

            <div class="form-group">
              <label for="firstname"> <span class="FieldInfo"> Address </span></label>
              <input class="form-control" type="text" name="address" id="address" value="">
            </div>

            <div class="form-group">
              <label for="firstname"> <span class="FieldInfo"> Deal Package </span></label>
              <select class="form-control" id="dealPackage" name="dealPackage">
                <option value="10MB">10 MB </option>
                <option value="100MB">100 MB </option>
                <option value="500MB">500 MB </option>
                <option value="1GB">1 GB </option>
              </select>
            </div>

            <div class="form-group">
              <label for="firstname"> <span class="FieldInfo"> Sector </span></label>
              <input class="form-control" type="text" name="sector" id="sector" value="">
            </div>

            <div class="offset-lg-3 col-lg-5 mb-2">
              <button type="submit" name="Submit" class="btn btn-success btn-block">Submit</button>
            </div>
          </div>
        </div>
    </div>
    </form>
  </div>
  </div>

</section>



<!-- End Main Area -->
<!-- FOOTER -->
<footer class="bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="lead text-center"></p>
      </div>
    </div>
  </div>
</footer>
<div style="height:50px; background:#27aae1;"></div>
<!-- FOOTER END-->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>