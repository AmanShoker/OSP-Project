<?php
session_start(); // Start the session
$_SESSION = array();
session_destroy();

header("Location: Homepage.php");
exit();
?>