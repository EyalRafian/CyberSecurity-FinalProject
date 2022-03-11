<?php
include('include/functions.php');
if (isset($_SESSION['userId'])) {
    redirect('./loggedInPages/dashboard.php');
} else {
    redirect('./notLoggedInPages/signIn.php');
}
