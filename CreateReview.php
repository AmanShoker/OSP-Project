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
                <li>
                    <a href="#">Reviews</a>
                    <ul class="dropdown">
                        <li><a href="Reviews.php">View Reviews</a></li>
                        <?php 
                        if (isset($_SESSION['username'])){
                            echo "<li><a href='CreateReview.php'>Create Review</a></li>";
                        }
                        ?>
                    </ul>
                </li>
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
                            <input type="text" name="searchQuery" placeholder="Search by Order-Id">
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
        
        <form action="CreateReview.php" method="post">
        <table>
            <thead>
                <h2>Leave a review letting everyone know what you think about a product or service!</h2>
            </thead>
            <tbody>
                <tr> <th>Review</th> <th>Rating</th> </tr>
                <tr> <td> <input name="review" type="text" size="150" maxlength="150"> </td> <td> <input name="rating" type="number" value=1 min="1" max="5"> </td> </tr>
            </tbody>
        </table>
        <input style="float:right; margin-right:5%;" type="submit" name="createReview" value="Create">
        </form>

        <?php
        require "ReviewTableController.php";
        if (isset($_POST["createReview"])){
            $UTC = New UserTableController();
            $RTC = New ReviewTableController();
            $username = $_SESSION["username"];
            $password = $_SESSION["password"];
            $userIdRecordArray = $UTC->getUserId($conn,$username,$password);
            $userIdRecord = $userIdRecordArray->fetch_assoc();
            $userId = $userIdRecord["userId"];
            $review = $_POST["review"];
            $rating = $_POST["rating"];
            $RTC->createReview($conn,$userId,$review,$rating);
            $_POST = array(); ?>

            <script>alert("Your review has been created");</script>

        <?php
        }
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
