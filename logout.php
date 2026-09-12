<?php
session_start();        // Start the session
session_unset();        // Remove all session variables
session_destroy();      // Destroy the session from server
header("Location: login.php"); // Redirect to login page
exit();
?>