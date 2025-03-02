<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Electronics Catalogue</title>
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
                window.close();
            }
            else if (itemStatus === 'False'){
                alert("Item Already contained in shopping cart");
                window.close();
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
            <h2 style="text-align:center;">Drag the image of the item that you are interested in purchasing into the shopping cart</h2>
            <?php
                require "connect.php";
                require "ItemTableController.php";
                $ITC = New ItemTableController();
                $result = $ITC->getAllItems($conn);
                echo "<table>";
                echo "<tr> <th>Image</th> <th>Product Name</th> <th>Price</th> <th>Made In</th> <th>Department Code</th> </tr>";
                while ($row = $result->fetch_assoc()){
                    $Id = $row["itemId"];
                    $imageLoc = $row["imageLoc"];
                    $itemName = $row["itemName"];
                    $price = $row["price"];
                    $madeIn = $row["madeIn"];
                    $departmentCode = $row["departmentCode"];
                    if (isset($_SESSION['username'])) {
                        echo "<tr> <td><img src='$imageLoc' draggable='true' ondragstart='drag(event)' id='$Id' class='ItemImage'></td> <td>$itemName</td> <td>$$price</td> <td>$madeIn</td> <td>$departmentCode</td> </tr>";
                    } else {
                        echo "<tr> <td><img src='$imageLoc' draggable='false' ondragstart='drag(event)' id='$Id' class='ItemImage'></td> <td>$itemName</td> <td>$$price</td> <td>$madeIn</td> <td>$departmentCode</td> </tr>";
                    }
                }
                echo "</table>";
            ?>
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
