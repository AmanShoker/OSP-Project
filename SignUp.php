<?php 

require "connect.php"; 
require "UserTableController.php";

$UTC = New UserTableController();

$username = $_POST['username'];
$password = $_POST['password'];
$fullName = $_POST['name'];
$telNo = $_POST['telno'];
$address = $_POST['address'];
$cityCode = $_POST['citycode'];
$email = $_POST['email'];
$balance = 0;


$UTC->insertRecord($conn,$fullName,$telNo,$email,$address,$cityCode,$username,$password,$balance);

//header("Location: Homepage.html");
//exit();

$conn->close();
?>