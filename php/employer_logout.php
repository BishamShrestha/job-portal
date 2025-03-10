<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the home page or login page after logout
header("Location: index.php"); // Redirect to home or login page after logout
exit();
?>