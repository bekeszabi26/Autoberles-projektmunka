<?php
session_start();
include_once "backend/config.php";
$out = "";
$carId = "";
if (isset($_SESSION['RenterID'])) {
    $renterId = $_SESSION['RenterID'];
    if (isset($_GET["carId"])) {
        $carId = $_GET["carId"];
        // Most már a $carId változóban van a CarID értéke
        //echo "CarID: " . $carId; ezzel ellenőriztem meg e kapom az ID-t
    }       
    // Űrlap elküldése
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //print_r("fut"); ellenőrizem hogy lefut a függvény gombkattintásra
        $startingDay = $_POST['startingDay'];
        $endingDay = $_POST['endingDay'];
        //print_r($startingDay); ellenőriztem hogy kezembe kerültek e az adatok
        //print_r($endingDay);
        $sql2 = mysqli_query($conn, "INSERT INTO reservation (RenterID, CarID, StartingDay, EndingDay)
                VALUES ('{$renterId}', '{$carId}', '{$startingDay}', '{$endingDay}')");
        $kimenet = "";
        if ($sql2 > 0) {
            $kimenet = "
                        <p>Köszönjük a foglalást!</p>
                        <p>Munkatársaink hamarosan felveszik Önnel a kapcsolatot Email-ben!</p>
                        <p><a href=\"profilF.php\">Vissza a profil oldalra</a></p>";
        }
        
    }
}else{
    $out = 'A foglaláshoz be kell jelentkeznie!';
}

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            <p><h1>{{car.BrandName}} {{ car.CarModelName }}</h1></p>
            <p><strong>Leírás:</strong> {{ car.Description }}</p>
            <p><strong>Szine:</strong> {{ car.Color }}</p>
            <p><strong>Kivitel:</strong> {{ car.BodyTypeName }}</p>
            <p><strong>Motor:</strong> {{ car.Engine }} cm<sup>3</sup></p>
            <p><strong>Lőerő:</strong> {{ car.Performance }}</p>
            <p><strong>Váltó:</strong> {{ car.TransmissionType }}</p>
            <p><strong>Meghajtás:</strong> {{ car.DriveName }}</p>
            <p><strong>Üzemanyag:</strong> {{ car.FuelName }}</p>
            <p><strong>Ülések száma:</strong> {{ car.Seats }}</p>
            <p><strong>Gyártási év:</strong> {{ car.ProductionYear }}</p>            
            <p><strong>Kaució:</strong> {{ car.Deposit }}Ft</p>
            <p><strong>Ár/Nap:</strong> {{ car.PricePerDay }}Ft</p>
            <!-- Foglalási időszak -->
            <label for="startingDay">Foglalás kezdete:</label>
            <input type="date" id="startingDay" name="startingDay" min="<?php echo date('Y-m-d'); ?>" required><br>

            <label for="endingDay">Foglalás vége:</label>
            <input type="date" id="endingDay" name="endingDay" min="<?php echo date('Y-m-d'); ?>" required><br>
            
            <?php if (isset($kimenet)) { echo $kimenet; } ?>
            
            <button type="submit" name="reserve" id="reserveButton">Foglalás</button>
            <strong class="foglalalert"><?php echo $out; ?></strong>
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
                let modal = document.getElementById("myModal");
                let modalImg = document.getElementById("img01");
                modal.style.display = "block";
                modalImg.src = imageUrl;
            }

            // Nagy kép elrejtése
            $scope.hideImage = function () {
                let modal = document.getElementById("myModal");
                modal.style.display = "none";
            }

            // Get the modal
            let modal = document.getElementById("reservationModal");

            // Get the button that opens the modal
            let btn = document.getElementById("reserveButton");

            // Get the <span> element that closes the modal
            let span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function () {
                // Check if both date inputs are filled
                let startingDay = document.getElementById("startingDay").value;
                let endingDay = document.getElementById("endingDay").value;
                if (startingDay && endingDay) {
                    //modal.style.display = "block";
                } else {
                    swal("Kérjük, töltse ki mindkét dátummezőt!");
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
        function salert()
        {
            swal({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            button: "Aww yiss!",
            });
        }
    </script>
</body>

</html>