<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OSP Homepage</title>
        <link rel="icon" href="images/shopping_icon.png" type="image/png">
        <link rel="stylesheet" href="OSPstyles.css">
    </head>
    <body>
        <header>
            <ul>
                <li><img src="images/shopping_icon.png"></li>
                <li><a href=Homepage.html>Home</a></li>
                <li><a href=AboutUsPage.html>About Us</a></li>
                <li>
                    <a href="#">Types of Services</a>
                    <ul class="dropdown">
                        <li><a href="Catalogue.php">Shopping</a></li>
                        <li><a href="#">Delivery</a></li>
                        <li><a href="#">Payment</a></li>
                    </ul>
                </li>
                <li><a href="ShoppingCart.php">Shopping Cart</a></li>
                <li><a href="#">Reviews</a></li>
                <li id="signIn-Up">
                    <a href="SignIn.html" class="sign-in">Sign-in</a>
                    <a href="SignUp.html" class="sign-up">Sign Up</a>
                </li>
            </ul>
        </header>
        <div id="welcome"></div>

        <script src="SignedIn.js"></script>
        <script>
        if (isSignedIn === 'true' && username) {
            document.getElementById('welcome').innerHTML = `<h1>Welcome back, ${username}!</h1>`;
        } else {
            document.getElementById('welcome').innerHTML = `<h1>Welcome to Our Site</h1>`;
        }
        </script>
    </body>
</html>