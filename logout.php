<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_unset();  // Unsets all session variables
session_destroy(); // Destroys the session

// Redirect to the login page
header("Location: index.php"); // Change to your login page path if necessary
exit();
?>
