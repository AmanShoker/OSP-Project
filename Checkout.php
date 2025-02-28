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

        <div class="centre">
            <div class="cart_card">
                <h1>Items in Cart</h1>
                <?php
                $records = array_values($_POST);
                echo "<table class='cart_table'>";
                echo "<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>";
                $subTotal = 0;
                foreach ($records as $record) {
                    echo "<tr><td>$record[0]</td><td>x$record[1]</td><td>$record[2]</td></tr>";
                    $temp = substr($record[2], 1);
                    $subTotal += $temp;
                }
                echo "</table>";
                echo "<div class='total_price'>TOTAL: $$subTotal</div>";
                ?>   
            </div>
        </div>
        <div class="centre">
            <div class="info_card">
                <section>
                    <h1>Payment Information</h2>
                    <form method='get' action='ProcessPayment.php'>
                        <label for='branches'>Select Branch Location:</label>
                        <select id='branches' name='branches' onchange='initMap()'>
                            <option value='B1'>Downtown Toronto Branch</option>
                            <option value='B2'>Etobicoke Branch</option>
                            <option value='B3'>Mississauga Branch</option>
                        </select><br><br>
                        <label for='deliveryDate'> Select Delivery Date:</label>
                        <input type="date" name="deliveryDate" id="deliveryDate" required>
                        <label for="cardNumber">Card Number:</label>
                        <input type="text" id="cardNumber" name="cardNumber" required>
                        <label for="expiryDate">Expiry Date:</label>
                        <input type="month" id="expiryDate" name="expiryDate" required>
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" required>
                        <input type="hidden" name="totalPayment" value="<?php echo $subTotal; ?>">
                        <button type="submit">Pay</button>
                    </form>
                </section>
                <div id="map"></div>
            </div>
        </div>


        <script>
        const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
        document.getElementById('deliveryDate').setAttribute('min', today);
        </script>

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
    </body>
</html>
