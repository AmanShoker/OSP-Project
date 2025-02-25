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
        <link rel="stylesheet" href="OSPstyles.css">
    </head>
    <body>
    <header>
            <ul>
                <li><img src="images/shopping_icon.png"></li>
                <li><a href=Homepage.php>Home</a></li>
                <li><a href=AboutUsPage.php>About Us</a></li>
                <li>
                    <a href="#">Types of Services</a>
                    <ul class="dropdown">
                        <li><a href="Catalogue.php">Shopping</a></li>
                        <li><a href="Delivery.php">Delivery</a></li>
                        <li><a href="Payment.php">Payment</a></li>
                    </ul>
                </li>
                <li id="shoppingCart" ondrop="drop(event)" ondragover="allowDrop(event)"><a href="ShoppingCart.php">Shopping Cart</a></li>
                <li><a href="#">Reviews</a></li>
                <li>
                    <a href="#">DB Maintain</a>
                    <ul class="dropdown">
                        <li><a href="AdminInsert.php">Insert</a></li>
                        <li><a href="AdmionDelete.php">Delete</a></li>
                        <li><a href="AdminSelect.php">Select</a></li>
                        <li><a href="AdminUpdate.php">Update</a></li>
                    </ul>
                </li>
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

        <script src="SignedIn.js"></script>

        <main>
            <?php
            require "connect.php";
            require "UserTableController.php";

            $UTC = New UserTableController();
            
            $username=$_SESSION["username"];
            $password=$_SESSION["password"];
            $userIdRecordArray = $UTC->getUserId($conn,$username,$password);
            $userIdRecord = $userIdRecordArray->fetch_assoc();
            $userId=$userIdRecord["userId"];
            
            $result = $UTC->getUserRecord($conn,$userId);
            $record = $result->fetch_assoc();
            $userBalance = $record['balance'];
            
            $subTotal = $_GET['totalPayment'];
            if ($userBalance < $subTotal){
                header("Location: ShoppingCart.php?error=paymentFailed");
            }
            echo "<h1 style='text-align:center;'>Your payment has been processed and shall be delivered to you by your specified date!</h1>";

            ?>
        </main>
    </body>
</html>
