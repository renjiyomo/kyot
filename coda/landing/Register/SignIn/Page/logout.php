<?php
session_start();
session_destroy(); // Destroy all sessions

// Redirect to the login page after logout
header('Location: /coda/landing/Register/SignIn/signin.php');
exit();
?>
