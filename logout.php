<?php
// Start session to access session variables
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page (or any other page as needed)
header("Location: index.php");
exit();
?>
