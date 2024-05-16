<?php
session_start();

// Unset session variables related to user authentication
unset($_SESSION['loggedIN']);
unset($_SESSION['username']);

// Check if the user is an admin and unset the corresponding session variable
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
}

// Destroy the session
session_destroy();

// Redirect the user to the login page
header('Location: ../../loginPage.php');
?>