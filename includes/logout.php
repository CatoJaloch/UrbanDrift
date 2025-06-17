<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

header("Location: signup.php"); // Redirect to login or signup page
exit;
?>
