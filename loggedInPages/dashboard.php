<?php

include('../include/functions.php');
include('../include/sessions.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
is_authenticated();

if (isset($_GET["id"])) {
  global $db;
  $id = $_GET["id"];
  $sql = "DELETE FROM clients WHERE id='$id'";
  $success = $db->query($sql);
  if ($success) {
    $_SESSION["SuccessMessage"] = "Client Deleted Successfully ! ";
    redirect("./dashboard.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
    redirect("./dashboard.php");
  }
}

require_once('header.php');
?>
<!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class=" col-lg-12" style="min-height:400px;">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
      <h1 style="text-align: center;">Existing Clients</h2>
        <hr />
        <table class="table table-striped table-hover">
          <thead style="background-color: #9EB0CE;">
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>id number</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Sector</th>
              <th>Deal Package</th>
              <th></th>
            </tr>
          </thead>
          <?php
          global $db;
          $sql = "SELECT * FROM clients ORDER BY id";
          $Execute = $db->query($sql);
          while ($DataRows = $Execute->fetch()) {
            $clientId = $DataRows["id"];
            $firstName = $DataRows["firstName"];
            $lastName = $DataRows["lastName"];
            $idNum = $DataRows["idNum"];
            $phoneNumber = $DataRows["phoneNumber"];
            $address = $DataRows["address"];
            $sector = $DataRows["sector"];
            $dealPackage = $DataRows["dealPackage"];
          ?>
            <tbody>
              <tr>
                <td><?php echo htmlentities($clientId); ?></td>
                <td><?php echo htmlentities($firstName); ?></td>
                <td><?php echo htmlentities($lastName); ?></td>
                <td><?php echo htmlentities($idNum); ?></td>
                <td><?php echo htmlentities($phoneNumber); ?></td>
                <td><?php echo htmlentities($address); ?></td>
                <td><?php echo htmlentities($sector); ?></td>
                <td><?php echo htmlentities($dealPackage); ?></td>
                <td> <a href="dashboard.php?id=<?php echo $clientId; ?>" class="btn btn-danger">Delete</a> </td>

            </tbody>
          <?php } ?>
    </div>
  </div>
  <!-- End Main Area -->

</section>
<?php include("footer.php"); ?>
</body>

</html>