<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>
        <link rel="icon" href="images/shopping_icon.png" type="image/png">
        <link rel="stylesheet" href="PaymentStyles.css">
    </head>
    <body>
    <header>
            <ul>
                <li><img src="images/shopping_icon.png"></li>
                <li><a href=Homepage.php>Home</a></li>
                <li><a href=AboutUsPage.php>About Us</a></li>
                <li>
                    <a href="#">Catalogue</a>
                    <ul class="dropdown">
                        <li><a href="Catalogue.php">Electronics</a></li>
                        <li><a href="#">Gardening</a></li>
                        <li><a href="#">Sports</a></li>
                        <li><a href="#">Clothes</a></li>
                    </ul>
                </li>
                <li id="shoppingCart" ondrop="drop(event)" ondragover="allowDrop(event)"><a href="ShoppingCart.php">Shopping Cart</a></li>
                <li><a href="#">Reviews</a></li>
                <?php 
                    require "connect.php";
                    require "UserTableController.php";
                    require "OrderTableController.php";
                    require "TripTableController.php";
                    require "TruckTableController.php";
                    require "ShoppingTableController.php";


                    
                    if (isset($_SESSION['username'])) {
                        $UTC = New UserTableController();
                        $username = $_SESSION["username"];
                        
                        if ($UTC->checkIfAdmin($conn,$username)): ?>
                <li>
                    <a href="#">DB Maintain</a>
                    <ul class="dropdown">
                        <li><a href="AdminInsert.php">Insert</a></li>
                        <li><a href="AdminDelete.php">Delete</a></li>
                        <li><a href="AdminSelect.php">Select</a></li>
                        <li><a href="AdminUpdate.php">Update</a></li>
                    </ul>
                </li>
                <?php endif; } ?>

                <?php if (isset($_SESSION['username'])): ?>
                    <li id="searchToggle">
                        <a id="searchLink">Search</a>

                        <form id="searchBar" action="Search.php" method="GET">
                            <input type="text" name="searchQuery" placeholder="Search by Order-Id (leave blank for all)">
                            <button type="submit" class="search">Search</button>
                        </form>
                    </li>
                <?php endif; ?>
                
                <li id="signIn-Up">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="SignOut.php" class="signOut">Sign Out</a>
                    <?php else: ?>
                        <a href="SignIn.html" class="sign-in">Sign-in</a>
                        <a href="SignUp.html" class="sign-up">Sign Up</a>
                    <?php endif; ?>
                </li>
            </ul>
        </header>

        <?php 
        $password=$_SESSION["password"];
        $userIdRecordArray = $UTC->getUserId($conn,$username,$password);
        $userIdRecord = $userIdRecordArray->fetch_assoc();
        $userId=$userIdRecord["userId"];

        $cartItemsSerialized = $_GET['cartItems'];
        $cartItems = unserialize($cartItemsSerialized); 
        
        $deliveryDate = $_GET['deliveryDate'];
        $selectedBranch = $_GET['branches'];
        $cardNumber = $_GET['cardNumber'];
        $expiryDate = $_GET['expiryDate'];
        $cvv = $_GET['cvv'];

        $OTC = New OrderTableController();
        $TripTC = New TripTableController();
        $TruckTC = New TruckTableController();
        $STC = New ShoppingTableController();
        ?>

        <div class="receipt_container">
            <h1>Payment Receipt</h1>
            <div class="receipt_details">
                <h2>Order Summary</h2>
                <table class="cart_table">
                    <tr><th>Name</th><th>Quantity</th><th>Price</th></tr>
                    <?php
                    $subTotal = 0;
                    foreach ($cartItems as $item) {
                        echo "<tr><td>$item[0]</td><td>x$item[1]</td><td>$item[2]</td></tr>";
                        $temp = substr($item[2], 1);
                        $subTotal += $temp;
                    }

                    $Total = $subTotal * 1.13;
                    ?>
                </table>


                <div class="total_price">SUBTOTAL: $<?php echo $subTotal; ?><br>TOTAL: $<?php echo $Total; ?>
                </div>

                <h2>Payment Details</h2>
                <p><strong>Selected Branch:</strong> <?php echo $selectedBranch; ?></p>
                <p><strong>Card Number:</strong> <?php echo $cardNumber; ?></p>
            </div>
            <div class="thank_you">
                <p>Thank you for shopping with us! Your order will be delivered <?php echo $deliveryDate; ?></p>
            </div>
        </div>
        <?php 
            function getTodayDate() {
                return date("Y-m-d"); 
            }
            $dateIssued = getTodayDate();

            if ($selectedBranch == "Downtown Toronto Branch") {
                $truckCode = 'TT';
            } else if ($selectedBranch == "Etobicoke Branch") {
                $truckCode = 'ET';
            } else if ($selectedBranch == "Mississauga Branch"){
                $truckCode = 'MT';
            }           

            $storeCode = 1456;
            $tripPrice = 50;
            $distance = 25;
            $paymentCode = 14145;

            $availabilityCode = rand(1111,9999);
            $TruckTC->insertRecord($conn,$truckCode,$availabilityCode);

            $RecordArray = $TruckTC->getTruckId($conn, $truckCode);
            $Record = $RecordArray->fetch_assoc();
            $truckId=$Record["truckId"];

            $RecordArray = $UTC->getAddress($conn, $username);
            $Record = $RecordArray->fetch_assoc();
            $destination=$Record["homeAddress"];

            $TripTC->insertRecord($conn, $selectedBranch, $destination, $distance, $truckId, $tripPrice);
            $STC->insertRecord($conn,$storeCode, $Total);

            $RecordArray = $TripTC->getTripId($conn, $destination, $truckId);
            $Record = $RecordArray->fetch_assoc();
            $tripId=$Record["tripId"];

            $RecordArray = $STC->getReceipt($conn, $storeCode, $Total);
            $Record = $RecordArray->fetch_assoc();
            $receiptId=$Record["receiptId"];

            $OTC->createOrder($conn,$dateIssued,$deliveryDate,$Total,$paymentCode,$userId,$tripId,$receiptId);
        ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchLink = document.getElementById('searchLink');
                const searchForm = document.getElementById('searchBar');

                searchLink.addEventListener('click', function(e) {
                    searchForm.classList.toggle('show');
                });
            });
        </script>
    </body>
</html>
