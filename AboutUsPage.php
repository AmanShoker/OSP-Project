<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
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

        <section id="about-us">
            <h2>About Us</h2>
            <div class="team-members">

                <div class="member-card">
                    <img src="images/tempPFP.png" alt="Aman Shoker">
                    <h3>Aman Shoker</h3>
                    <p class="bio">I love Basketball.</p>
                    <p class="contact">Email: aman.shoker@torontomu.ca</p>
                </div>

                <div class="member-card">
                    <img src="images/anthony.jpeg" alt="images/tempPFP.png">
                    <h3>Anthony Pochapsky</h3>
                    <p class="bio">Tech dude</p>
                    <p class="contact">Email: apochapsky@torontomu.ca</p>
                </div>

                <div class="member-card">
                    <img src="images/AymanPFP.jpg" alt="name">
                    <h3>Ayman Mohammad</h3>
                    <p class="bio">Computer Science @ TMU</p>
                    <p class="contact">Email: ayman.mohammad@torontomu.ca</p>
                </div>
            </div>
        </section>

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
