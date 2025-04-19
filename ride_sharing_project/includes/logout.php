<?php
session_start();

// Destroy the session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

echo "You have logged out successfully!";
header("Location: login.php"); // Redirect to the login page
?>
