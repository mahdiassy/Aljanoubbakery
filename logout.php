<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page or any other desired page after logout
header("Location: index.php"); // Change 'index.php' to your desired page
exit();
?>
