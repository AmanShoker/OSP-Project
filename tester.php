<?php
require "connect.php";

//Foreign keys not included
require "ShoppingTableController.php";
require "TruckTableController.php";
require "UserTableController.php";
require "ItemTableController.php";


//Foreign keys included
require "TripTableController.php";
require "OrderTableController.php";


//Define controllers
$STC = New ShoppingTableController();
$TruckTC = New TruckTableController();
$UTC = New UserTableController();
$ITC = New ItemTableController();
$TripTC = New TripTableController();
$OTC = New OrderTableController();

//Populate DB with tables in order based on foreign keys
$STC->createTable($conn);
$TruckTC->createTable($conn);
$UTC->createTable($conn);
$ITC->createTable($conn);
$TripTC->createTable($conn);
$OTC->createTable($conn);


//Terminate connection
$conn->close();
?>
