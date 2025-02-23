<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Catalogue</title>
        <link rel="icon" href="images/shopping_icon.png" type="image/png">
        <link rel="stylesheet" href="OSPstyles.css">
        <link rel="stylesheet" href="CatalogueStyles.css">

    <script>
        function allowDrop(ev) {
        ev.preventDefault();
        }
        function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        }
        function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        window.open("addNewShoppingCartItem.php?itemId=" + data);
        }
    </script>

    </head>
    <body>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            const itemStatus = urlParams.get('added');

            if (itemStatus === 'True') {
                alert("Successfully added to your shopping cart");
            }
            else if (itemStatus === 'False'){
                alert("Item Already contained in shopping cart");
            }
        </script>
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
            <h2 style="text-align:center;">Drag the image of the item that you are interested in purchasing into the shopping cart</h2>
            <?php
                require "connect.php";
                require "ItemTableController.php";
                $ITC = New ItemTableController();
                $result = $ITC->getAllItems($conn);
                echo "<table>";
                echo "<tr> <th>Image</th> <th>Name</th> <th>Price</th> <th>MadeIn</th> <th>Department Code</th> </tr>";
                while ($row = $result->fetch_assoc()){
                    $Id = $row["itemId"];
                    $imageLoc = $row["imageLoc"];
                    $itemName = $row["itemName"];
                    $price = $row["price"];
                    $madeIn = $row["madeIn"];
                    $departmentCode = $row["departmentCode"];
                    echo "<tr> <td><img src='$imageLoc' draggable='true' ondragstart='drag(event)' id='$Id' class='ItemImage'></td> <td>$itemName</td> <td>$price</td> <td>$madeIn</td> <td>$departmentCode</td> </tr>";
                }
                echo "</table>";
            ?>
        </main>
    </body>
</html>