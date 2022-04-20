<?php


if (isset($_POST['SignIn'])) {

  $userName        = $_POST["Username"];
  $password        = $_POST["Password"];
  $confirmPassword = $_POST["ConfirmPassword"];
  $email           = $_POST["Email"];

  // Check for empty filed.
  if (empty($userName) || empty($password) || empty($email) || empty($confirmPassword)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    redirect('signIn.php');
  }
  // Verify corret email pattern.
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["ErrorMessage"] = "Please enter valid email";
    redirect('signIn.php');
  }
  // Verify password and confirmPassword are match.
  else if ($password !== $confirmPassword) {
    $_SESSION["ErrorMessage"] = "Passwords not the same !";
    redirect('signIn.php');
  }
  // Check if user exsists on the database.
  else if (get_user($userName)) {
    $_SESSION["ErrorMessage"] = "User already exists !";
    redirect('signIn.php');
  }
  // Check if Email exsists on the database.
  else if (check_email($email)) {
    $_SESSION["ErrorMessage"] = "Email is taken register with another one !";
    redirect('signIn.php');
  }

  // Check password strenght from configuration file , if the password passed all tests a hashed password will return.
  $password = password_policy($password);
  if ($password == false) {
    redirect('./signIn.php');
  } else {
    // Create a new user on the database and return a user object.
    $user = create_new_user($userName, $password, $email);
    if ($user) {
      // Set up all session variables from user object and redirect to dashboard.
      $_SESSION["SuccessMessage"] = "New user with the name of " . $user["username"] . " added Successfully";
      $_SESSION["userId"] = $user["id"];
      $_SESSION["userName"] = $user["username"];
      $_SESSION["email"] = $user["email"];
      $_SESSION["SuccessMessage"] = "Wellcome " . $_SESSION["userName"] . "!";
      redirect('../loggedInPages/dashboard.php');
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
      redirect("./signIn.php");
    }
  }
}
?>

  <!-- Main Area Start -->
  <section class="">
    <div class="row">
      <div class="col-lg-6" style="min-height:400px;">
        <br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="signIn.php" method="post">
          <div class="card text-light mb-3" style="background-color: #90a4ae;">
            <div class="card-header" style="text-align: center;">
              <h1>Sign Up</h1>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="username"> <span class="FieldInfo"> Username: </span></label>
                <input class="form-control" type="text" name="Username" id="username" value="">
              </div>
              <div class="form-group">
                <label for="email"> <span class="FieldInfo"> Email: </span></label>
                <input class="form-control" type="text" name="Email" id="email" value="">
              </div>
              <div class="form-group">
                <label for="Password"> <span class="FieldInfo"> Password: </span></label>
                <input class="form-control" type="password" name="Password" id="Password" value="">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword"> <span class="FieldInfo"> Confirm Password:</span></label>
                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
              </div>
              <div class="row">
                <div class="mx-auto">
                  <button type="submit" name="SignIn" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Sign Up
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="jumbotron col-lg-5 mt-5 mr-2">
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

  <!-- Main Area End -->