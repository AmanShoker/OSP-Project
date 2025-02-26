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
require "ShoppingCartTableController.php";

//Define controllers
$STC = New ShoppingTableController();
$TruckTC = New TruckTableController();
$UTC = New UserTableController();
$ITC = New ItemTableController();
$TripTC = New TripTableController();
$OTC = New OrderTableController();
$SCTC = New ShoppingCartTableController();

//Populate DB with tables in order based on foreign keys
$STC->createTable($conn);
$TruckTC->createTable($conn);
$UTC->createTable($conn);
$ITC->createTable($conn);
$TripTC->createTable($conn);
$OTC->createTable($conn);
$SCTC->createTable($conn);

//Populate Tables with records that must exist before any user interaction
$TruckTC->insertRecord($conn,"ST",5325);
$TruckTC->insertRecord($conn,"MT",3258);

$ITC->insertRecord($conn,"images/macbookpro.png","Apple MacBook Pro",1200,"Canada","E");
$ITC->insertRecord($conn,"images/notebook9.png","Samsung Notebook 9",800,"USA","E");
$ITC->insertRecord($conn,"images/ipadpro.png","Apple Ipad Pro Tablet",750,"Canada","E");
$ITC->insertRecord($conn,"images/bold9900.png","BlackBerry Bold 9900",600,"USA","E");

//Insert root user admin account
$UTC->insertAdminRecord($conn,"root","1234",1);

//Terminate connection
$conn->close();
?>
