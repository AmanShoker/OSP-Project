<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
        <link rel="icon" href="images/shopping_icon.png" type="image/png">
        <link rel="stylesheet" href="OSPstyles.css">
        <link rel="stylesheet" href="CatalogueStyles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
    <body>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');

            if (error === 'paymentFailed') {
                alert("Failed to process your payment. Reason: low balance");
            }
    </script>

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
                    
                    if (isset($_SESSION['username'])) {
                        $UTC = New UserTableController();
                        $username = $_SESSION["username"];
                        
                        if ($UTC->checkIfAdmin($conn,$username)): ?>
                <li>
                    <a href="#">DB Maintain</a>
                    <ul class="dropdown">
                        <li><a href="AdminInsert.php">Insert</a></li>
                        <li><a href="AdmionDelete.php">Delete</a></li>
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

        <main>
            <?php
                require "ShoppingCartTableController.php";
                $SCTC = New ShoppingCartTableController();
                
                if (isset($_SESSION['username'])) {

                    $username=$_SESSION["username"];
                    $password=$_SESSION["password"];
                    $userIdRecordArray = $UTC->getUserId($conn,$username,$password);
                    $userIdRecord = $userIdRecordArray->fetch_assoc();
                    $userId=$userIdRecord["userId"];

                    $result=$SCTC->getShoppingCartItems($conn,$userId);
                
                    if($result->num_rows > 0){
                        echo "<form action='Checkout.php' method='post'>";
                        echo "<table>";
                        echo "<tr> <th>Remove</th> <th>Name</th> <th>Made In</th> <th>Quantity</th> <th>Price</th></tr>";
                        while ($row = $result->fetch_assoc()){
                        $itemId=$row["itemId"];
                        $itemName=$row["itemName"];
                        $price=$row["price"];
                        $madeIn=$row["madeIn"];
                        $departmentCode=$row["departmentCode"];
                        echo "<tr> <td><a id='remove' href='removeFromCart.php?itemId=$itemId'>Remove</a></td> <td><input style='text-align:center;' readonly name='{$itemId}[]' type='text' value='$itemName'></input></td> <td>$madeIn</td> <td><input style='text-align:center;' name='{$itemId}[]' type='number' value=1 itemPrice=$price updateFieldId=$itemId onKeyDown='return false' min='1' max='10'></td> <td><input style='text-align:center;' readonly name='{$itemId}[]' id=$itemId type='text' value='$$price'></input></td> </tr>";
                        }
                        echo "</table>";
                        echo "<input type=submit value=Checkout id='checkout'>";
                        echo "</form>";
                    }
                    else{
                        echo "<h2>Your Shopping Cart is Currently Empty</h2>";
                    }

                } else {
                    echo "<h2>Sign-in to View Your Shopping Cart</h2>";
                }
            ?>
            <p id="demo"></p>
            <script>
                $(":input[type=number]").bind('keyup mouseup', function () {
                    let priceId = $(this).attr("updateFieldId");
                    let quantity = $(this).val();
                    let price = $(this).attr("itemPrice");
                    document.getElementById(priceId).value = "$" + (price*quantity);       
                 });
            </script>
        </main>

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
