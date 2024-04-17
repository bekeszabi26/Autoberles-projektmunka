<?php
session_start();
include_once "backend/config.php";
?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JourneyGems - Autóink</title>
  <link rel="icon" type="image/x-icon" href="Pictures/logoFekete.png">
  <link rel="stylesheet" href="css/cars.css" />
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
  <style>
    .parallax {
      /* The image used / A felhasznált kép */
      background-image: url("Pictures/img/hatter2.png");

      /* Set a specific height */
      min-height: 100vh;

      /* Create the parallax scrolling effect */
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
    }
  </style>
</head>

<body ng-controller="CarController">
  <header>
    <!-- nav contrtainer -->
    <div class="container nav">
      <!-- menu icon -->
      <i class="bx bx-menu" id="menu-icon"></i>
      <!-- logo -->
      <a href="index.php" class="logo"><img src="Pictures/img/1-transparent.png" alt="" srcset=""></span></a>
      <!-- nav list -->
      <nav class="navbar">
        <a href="index.php" style="--i:1">Kezdőlap</a>
        <a href="cars.php" style="--i:2" class="active">Autóink</a>
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
    </div>
  </header>

  <div class="parallax">
    <section class="home" id="home">
      <div class="home-text">
        <h1>
          Béreljen személyautót a<br />
          <span>JourneyGems-nél!</span>
        </h1>
        <p>
          Nálunk egyszerűen és gyorsan kiválaszthatja<br>
          az Ön számára megfelelő autót. A JourneyGems-nél könnyedén megtalálja az Önnek igazán testhezálló, jól
          felszerelt,<br>
          biztonságos személyautót, hogy az utazás egy igazi élménnyé váljon.<br>
        </p>
        <!-- home Button -->
        <a href="#" class="btn">Érdekel!</a>
      </div>
    </section>
  </div>
  <!-- Home section -->
  <!-- Cars section -->

  <div class="slider-wrapper" id="cards">
    <section class="cars">
      <div class="card" ng-repeat="car in cars" ng-click="goToDetails(car)">
        <div class="card-image"><img ng-src={{getFirstImage(car.Picture)}}></div>
        <div class="card-text">
          <h2>{{car.BrandName}} {{ car.CarModelName }}</h2>
          <p>{{ car.Description | limitTo:150}}...</p>
        </div>
        <div class="card-stats">
          <div class="stat">
            <div class="value">{{car.Performance}}</div>
            <div class="type">Lőerő</div>
          </div>
          <div class="stat border">
            <div class="value">{{car.Seats}}</div>
            <div class="type">Ülések Száma</div>
          </div>
          <div class="stat">
            <div class="value">{{car.ProductionYear}}</div>
            <div class="type">Gyártási Év</div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer section -->
  <section class="footer">
    <div class="footer-container container">
      <div class="footer-box">
        <a href="#" class="logo"><img src="Pictures/logoFekete.png"></a>
        <div class="social">
          <a href="https://twitter.com/?lang=hu" target="_blank"><i class="bx bxl-twitter"></i></a>
          <a href="https://www.facebook.com/" target="_blank"><i class="bx bxl-facebook"></i></a>
          <a href="https://www.instagram.com/" target="_blank"><i class="bx bxl-instagram"></i></a>
        </div>
      </div>

      <div class="footer-box">
        <h3>Oldalaink</h3>
        <a href="index.php">Kezdőlap</a>
        <a href="cars.php">Autóink</a>
        <a href="profilF.php">Profil</a>
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
      </div>

      <div class="footer-box">
        <h3>Információk</h3>
        <a href="#">Felhasználási feltételek, adatvédelem</a>
        <a href="#">Pénzvisszatérítési eljárás</a>
        <a href="#">Cookie-kra vonatkozó szabályzat</a>
      </div>

      <div class="footer-box">
        <h3>Lépj kapcsolatba velünk!</h3>
        <p>E-mail: journeygems@gmail.com</p>
        <p>Tel.: 06501234567</p>
      </div>
    </div>
  </section>

  <script>


    // Define AngularJS app
    let app = angular.module('myApp', []);

    // Define controller
    app.controller('CarController', function ($scope, $http, $window) {
      // Fetch data from backend using $http
      $http.get('backend/get_cars.php').then(function (response) {
        // Assign response data to $scope.cars
        $scope.cars = response.data;
        console.log($scope.cars); // Ellenőrzés céljából, hogy valóban érkeznek-e adatok
        $scope.goToDetails = function (car) {
        //Az autó azonosítójának használata URL paraméterként
        $window.location.href = 'carDetails.php?carId=' + car.CarID;
      }
      }).catch(function (error) {
        console.error('Error fetching cars:', error);
      });
      

      $scope.getFirstImage = function (imageList) {
        if (imageList) {
          return imageList.split(',')[0];
        } else {
          return ''; // Üres string, ha nincs kép
        }
      };
    });


    // menu
    let menu = document.querySelector('.navbar');
    document.querySelector('#menu-icon').onclick = () => {
      menu.classList.toggle('active');
    }

    //  hides menu when scroll
    window.onscroll = () => {
      menu.classList.remove('active');
    }
    // Header
    let header = document.querySelector("header");

    window.addEventListener("scroll", () => {
      header.classList.toggle("shadow", window.scrollY > 0);
    });
  </script>
  <script src="js/cars.js"></script>
</body>

</html>