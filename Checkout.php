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
    <style>
        #map {
            height:500px;
            width:500px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
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
            $records = array_values($_POST);
            echo "<table style='width:50%;'>";
            echo "<tr><th>Name</th> <th>Quantity</th> <th>Price</th></tr>";
            $subTotal = 0;
            foreach  ($records as $record){
                echo "<tr> <td>$record[0]</td> <td>x$record[1]</td> <td>$record[2]</td> </tr>";
                $temp = substr($record[2],1);
                $subTotal += $temp;
            }
            echo "</table>";
            echo ".................................................................................................<br>";
            echo "<div style='width:60%; float:right; font-weight:bold;'>TOTAL:$$subTotal</div> <br><br>";    
            
            
        echo "
        <div>
            <form style='float:left;' method='get' action='ProcessPayment.php'>
                
                <label for='branches'>Select one of our three branch locations nearest to you:</label>
                <select id='branches' name='branches' onchange='initMap()''>
                    <option value='B1'>Branch 1</option>
                    <option value='B2'>Branch 2</option>
                    <option value='B3'>Branch 3</option>
                </select><br><br>
                <label for='deliveryDate'> Select a date for when you want your products to be delivered to you:</label>
                <input type='date' name='deliveryDate' value='2025-01-01' min='2025-01-01' max='2025-12-31'><br><br>
                <label for='paymentOption'>Select a payment option:</label>
                <select name='paymentOption'>
                    <option value='creditCard'>Credit Card</option>
                </select><br><br>
                <input type='hidden' name='totalPayment' value='$subTotal'>
                <input type='submit' value='Process Payment'><br><br>
            </form>
        </div> "
        ?>
        <div style="float:left; margin-left:5%;" id="map"></div>
        <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc8t67_v0mNHJg-ISUBvdKg2vihgVIZJU&loading=async&libraries=visualization&callback=initMap">
        </script>
        <script>
                var userLat;
                var userLng;
                var userPositionMarker;
                var map;

                var selectedBranchLat;
                var selectedBranchLong;
                var selectedBranchMarker;

                var directionRenderer;

                var options;
                var mapLoads = 0;

             async function initMap(){
                const userIconUrl = "https://img.buzzfeed.com/buzzfeed-static/static/enhanced/webdr06/2013/4/11/1/enhanced-buzz-24965-1365659349-6.jpg?downsize=700%3A%2A&output-quality=auto&output-format=auto";
                const branchIconUrl = "https://cdn-icons-png.flaticon.com/512/5439/5439360.png";

                const userIcon ={
                    url: userIconUrl,
                    scaledSize: new google.maps.Size(50, 50)
                };
                const branchIcon ={
                    url: branchIconUrl,
                    scaledSize: new google.maps.Size(50, 50)
                };

                if (mapLoads == 0){
                navigator.geolocation.getCurrentPosition(showPosition);
                mapLoads = 1;
                }
                else{
                setBranchLocMarker();
                }

                function showPosition(position){
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                options = {
                    zoom:10,
                    center:{lat:userLat,lng:userLng}
                    }
                map = new google.maps.Map(document.getElementById('map'), options);
                userPositionMarker = new google.maps.Marker({position:{lat:userLat,lng:userLng}, map:map, icon:userIcon});
                setBranchLocMarker();
                }

                function setBranchLocMarker(){
                    if (typeof selectedBranchMarker == "object" ){
                        selectedBranchMarker.setMap(null);
                    }
                    let selectedBranch = document.getElementById("branches").value;
                    if (selectedBranch == "B1"){
                        selectedBranchLat = 43.659561;
                        selectedBranchLong = -79.400377;
                    }
                    else if (selectedBranch == "B2"){
                        selectedBranchLat = 43.669121;
                        selectedBranchLong = -79.540505;
                    }
                    else if (selectedBranch == "B3"){
                        selectedBranchLat = 43.596023;
                        selectedBranchLong = -79.694742;
                    }
                    selectedBranchMarker = new google.maps.Marker({position:{lat:selectedBranchLat,lng:selectedBranchLong}, map:map, icon:branchIcon});
                    //selectedBranchMarker.setMap(map);
                    console.log();

                    createPathBetween(selectedBranchMarker.position,userPositionMarker.position);
                }

                function createPathBetween(start, end){
                    const request = {
                        origin: start,
                        destination: end,
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    }
                    if (typeof directionRenderer == "object"){
                        directionRenderer.setMap(null);
                    }
                    directionService = new google.maps.DirectionsService();
                    directionRenderer = new google.maps.DirectionsRenderer();
                    directionRenderer.setMap(map);
                    directionService.route(request, function(response, status){
                        if (status === google.maps.DirectionsStatus.OK){
                            directionRenderer.setDirections(response);
                        }
                    })
                }
        }
        </script>

        </main>
    </body>
</html>
