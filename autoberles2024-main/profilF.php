<?php
session_start();
include_once "backend/config.php";

// Ellenőrizze, hogy a felhasználó be van-e jelentkezve
if (!isset ($_SESSION['RenterID'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/profilCSS.css">
    <link rel="stylesheet" href="css/style3.css">
    <title>JourneyGems - Renter Profil</title>
    <link rel="icon" type="image/x-icon" href="Pictures/logoFekete.png">
</head>

<body ng-app="renterApp" ng-controller="RenterController" class="container">
    <header class="header">
        <!-- Logo and navigation bar for the website -->
        <a href="index.php" class="logo"><img src="Pictures/1-transparent.png" alt="" srcset="" id="logo"></a>

        <!-- Primary navigation -->
        <nav class="navbar">
            <a href="index.php" style="--i:1">Kezdőlap</a>
            <a href="cars.php" style="--i:2">Autóink</a>
            <a href="profilF.php" style="--i:3" class="active">Profil</a>
            <?php
            // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
            if(isset($_SESSION['RenterID'])) {
                // Ha be van jelentkezve, akkor a kijelentkezés menüpont jelenik meg
                echo '<a href="backend/logout.php" style="--i:4">Kijelentkezés</a>';
            } else {
                // Ha nincs bejelentkezve, akkor a regisztráció és bejelentkezés menüpontok jelennek meg
                echo '<a href="login.php" style="--i:4">Bejelentkezés</a>';
                echo '<a href="signup.php" style="--i:5">Regisztráció</a>';
            }
            ?>
        </nav>

        <div class="social-media">
            <a href="https://twitter.com/?lang=hu" target="_blank" style="--i:1"><i class='bx bxl-twitter'></i></a>
            <a href="https://www.facebook.com/" target="_blank" style="--i:2"><i class='bx bxl-facebook'></i></a>
            <a href="https://www.instagram.com/" target="_blank" style="--i:3"><i class='bx bxl-instagram-alt'></i></a>
        </div>

    </header>
    <div class="content">
        <div class="rhombus2"></div>
        <h2>Felhasználó adatai:</h2>
        <p>Vezetéknév: {{ renterData.Surname }}</p>
        <p>Keresztnév: {{ renterData.FirstName }}</p>
        <p>Email: {{ renterData.Email }}</p>
        <p>Telefonszám: {{ renterData.TelephoneNumber }}</p>

        <!-- Település adatai -->
        <div ng-if="settlementData">
            <h2>Település adatai:</h2>
            <p>Lakhely: {{ settlementData.SettlementName }}</p>
            <p>Irányítószám: {{ settlementData.ZipCode }}</p>
            <p>Megye: {{ settlementData.County }}</p>
        </div>

        <!-- Foglalás adatai -->
        <div ng-if="reservationData.length > 0">
            <h2>Reservation adatai:</h2>
            <ul>
                <li ng-repeat="reservation in reservationData">
                    <strong>ReservationID:</strong> {{ reservation.ReservationID }}<br>
                    <strong>CarID:</strong> {{ reservation.CarID }}<br>
                    <strong>StartingDay:</strong> {{ reservation.StartingDay }}<br>
                    <strong>EndingDay:</strong> {{ reservation.EndingDay }}<br>
                </li>
            </ul>
        </div>

        <form action="profilUpdate.php" method="get">
            <a href="profilUpdate.php"><button type="submit">Profil Módosítása</button></a>
        </form>
        <div class="darkmode-toggle" onclick="toggleDarkMode()">
            🌓
        </div>
    </div>
    <!-- Include AngularJS script -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="js/profil.js"></script>
    <script>
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('darkmode');
            lightMode();
        }
        function lightMode() {
            let logo = document.getElementById("logo");
            if (logo.getAttribute("src") === "Pictures/logoFekete.png") {
                logo.setAttribute("src", "Pictures/1-transparent.png");
            } else {
                logo.setAttribute("src", "Pictures/logoFekete.png");
            }
            const navbarLinks = document.querySelectorAll('.navbar a');
            console.log(navbarLinks)
            navbarLinks.forEach(link => {
                if (link.style.color === "white") {
                    link.style.color = "black";
                } else {
                    link.style.color = "white";
                }
            });
        }
    </script>
</body>

</html>