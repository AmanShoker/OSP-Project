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
        <link rel="stylesheet" href="CatalogueStyles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

        <main>
            <?php
            require "connect.php";
            require "UserTableController.php";
            require "ShoppingCartTableController.php";

            
            $SCTC = New ShoppingCartTableController();
            $UTC = New UserTableController();
            
            $username=$_SESSION["username"];
            $password=$_SESSION["password"];
            $userIdRecordArray = $UTC->getUserId($conn,$username,$password);
            $userIdRecord = $userIdRecordArray->fetch_assoc();
            $userId=$userIdRecord["userId"];

            $result=$SCTC->getShoppingCartItems($conn,$userId);
           
            if($result->num_rows > 0){
                echo "<form action='#' method='post'>";
                echo "<table>";
                echo "<tr> <th>Remove</th> <th>Name</th> <th>made In</th> <th>Quantity</th> <th>Price</th></tr>";
                while ($row = $result->fetch_assoc()){
                $itemId=$row["itemId"];
                $itemName=$row["itemName"];
                $price=$row["price"];
                $madeIn=$row["madeIn"];
                $departmentCode=$row["departmentCode"];
                echo "<tr> <td><a href='removeFromCart.php?itemId=$itemId'>Remove</a></td> <td>$itemName</td> <td>$madeIn</td> <td><input type='number' value=1 itemPrice=$price updateFieldId=$itemId onKeyDown='return false' min='1' max='10'></td> <td id=$itemId>$$price</td> </tr>";
                }
                echo "</table>";
                echo "<input type=submit value=Checkout style='float:right; margin-right:5%; padding: 8px 16px;background-color: #007bff;color: white;border: none;border-radius: 8px; '>";
                echo "</form>";
            }
            else{
                echo "<h2>Your shopping cart is currently empty</h2>";
            }
            ?>
            <p id="demo"></p>
            <script>
                $(":input[type=number]").bind('keyup mouseup', function () {
                    let priceId = $(this).attr("updateFieldId");
                    let quantity = $(this).val();
                    let price = $(this).attr("itemPrice");
                    document.getElementById(priceId).innerHTML = "$" + (price*quantity);       
                 });
            </script>
        </main>
    </body>
</html>