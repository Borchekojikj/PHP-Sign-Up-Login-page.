<?php
// Start the session
session_start();

// Unset all session variables


// Destroy the session
session_destroy();



// Redirect to the login page or any other page after logout
header("Location: login.php");
exit();
