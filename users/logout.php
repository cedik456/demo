<?php
session_start(); // Start or resume the session

// Clear the session variables and destroy the session
session_unset();
session_destroy();

// Redirect the user to the login page
header("Location: login.php");
exit();
?>
