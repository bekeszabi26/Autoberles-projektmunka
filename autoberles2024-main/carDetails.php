<?php
session_start();
include_once "backend/config.php";
?>
<!DOCTYPE html>
<html lang="en" ng-app="carApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JourneyGems - Autó</title>
    <link rel="icon" type="image/x-icon" href="Pictures/logoFekete.png">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/cardetails.css">
</head>

<body ng-controller="CarDetailsController">
    <header class="header">
        <!-- Logo and navigation bar for the website -->
        <a href="index.php" class="logo"><img src="Pictures/1-transparent.png" alt="" srcset="" id="logo"></a>

        <!-- Primary navigation -->
        <nav class="navbar">
            <a href="index.php" style="--i:1" class="active">Kezdőlap</a>
            <a href="cars.php" style="--i:2">Autóink</a>
            <a href="profilF.php" style="--i:3">Profil</a>
            <?php
            // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
            if (isset($_SESSION['RenterID'])) {
                // Ha be van jelentkezve, akkor a kijelentkezés menüpont jelenik meg
                echo '<a href="backend/logout.php" style="--i:4">Kijelentkezés</a>';
            } else {
                // Ha nincs bejelentkezve, akkor a regisztráció és bejelentkezés menüpontok jelennek meg
                echo '<a href="login.php" style="--i:4">Bejelentkezés</a>';
                echo '<a href="signup.php" style="--i:5">Regisztráció</a>';
            }
            ?>
        </nav>
    </header>

    <form method="POST" action="">
        <div class="cars">
            <div class="image-container" ng-repeat="picture in car.Picture.split(',')">
                <a ng-click="showImage(picture)">
                    <img class="car-image" ng-src="{{ picture }}" alt="Car Image">
                </a>
            </div>
            <!-- <p><h1>{{car.BrandName}} {{ car.CarModelName }}</h1></p> -->
            <p><strong>Leírás:</strong> {{ car.Description }}</p>
            <p><strong>Szine:</strong> {{ car.Color }}</p>
            <p><strong>Motor:</strong> {{ car.Engine }} cm<sup>3</sup></p>
            <p><strong>Lőerő:</strong> {{ car.Performance }}</p>
            <p><strong>Ülések száma:</strong> {{ car.Seats }}</p>
            <p><strong>Gyártási év:</strong> {{ car.ProductionYear }}</p>
            <!-- <p><strong>Váltó:</strong> {{ transmissiontype.TransmissionType }}</p> -->
            <p><strong>Kaució:</strong> {{ car.Deposit }}Ft</p>
            <p><strong>Ár/Nap:</strong> {{ car.PricePerDay }}Ft</p>
            <!-- Foglalási időszak -->
            <label for="startingDay">Foglalás kezdete:</label>
            <input type="date" id="startingDay" name="startingDay" min="<?php echo date('Y-m-d'); ?>" required><br>

            <label for="endingDay">Foglalás vége:</label>
            <input type="date" id="endingDay" name="endingDay" min="<?php echo date('Y-m-d'); ?>" required><br>

            <div id="reservationModal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <p>Köszönjük a foglalást!</p>
                    <p>Munkatársaink hamarosan felveszik Önnel a kapcsolatot Email-ben!</p>
                    <p><a href="index.php">Vissza a kezdő oldalra</a></p>
                </div>
            </div>
            <button type="button" name="reserve" id="reserveButton">Foglalás</button>
        </div>
    </form>

    <div id="myModal" class="modal">
        <span class="close" ng-click="hideImage()">&times;</span>
        <img class="modal-picture" id="img01">
    </div>
    <script src="js/checkDate.js"></script>
    <script>
        let app = angular.module('carApp', []);
        app.controller('CarDetailsController', function ($scope, $http) {
            let urlParams = new URLSearchParams(window.location.search);
            //az url-ből kiolvassuk a carId számát
            let carId = urlParams.get('carId');

            $http.get('http://localhost/autoberles2024.03.04/autoberles2024-main/backend/carDetails.php?carId=' + carId).then(function (response) {
                $scope.car = response.data;
                //Teszteltük, hogy megérkezik-e az adat
                console.log($scope.car);
            }).catch(function (error) {
                console.error('Error fetching car details:', error);
            });


            $scope.showImage = function (imageUrl) {
                var modal = document.getElementById("myModal");
                var modalImg = document.getElementById("img01");
                modal.style.display = "block";
                modalImg.src = imageUrl;
            }

            // Nagy kép elrejtése
            $scope.hideImage = function () {
                var modal = document.getElementById("myModal");
                modal.style.display = "none";
            }

            // Get the modal
            var modal = document.getElementById("reservationModal");

            // Get the button that opens the modal
            var btn = document.getElementById("reserveButton");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function () {
                // Check if both date inputs are filled
                var startingDay = document.getElementById("startingDay").value;
                var endingDay = document.getElementById("endingDay").value;
                if (startingDay && endingDay) {
                    modal.style.display = "block";
                } else {
                    alert("Kérjük, töltse ki mindkét dátummezőt!");
                }
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>