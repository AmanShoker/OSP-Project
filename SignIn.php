<?php 

require "connect.php"; 
require "UserTableController.php";

$UTC = New UserTableController();

$username = $_POST['username'];
$password = $_POST['password'];

if ($UTC->validLogin($conn,$username,$password)) {
    header("Location: Homepage.html");
    exit();
} else {
    header("Location: SignIn.html?error=insertfailed");
    exit();
}

?>