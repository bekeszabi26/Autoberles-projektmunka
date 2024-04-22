<?php
session_start();
include_once "backend/config.php";

// Ellenőrizze, hogy a felhasználó be van-e jelentkezve
if (!isset ($_SESSION['RenterID'])) {
    header("Location: login.php");
    exit();
}

// Delete Profile
if (isset($_POST['delete'])) {
    $userId = $_SESSION['RenterID'];
    $deleteQuery = "DELETE FROM renter WHERE RenterID = '$userId'";
    if ($conn->query($deleteQuery) === TRUE) {
        // Sikeres törlés esetén átirányítás
        header("Location: backend/logout.php");
        exit();
    } else {
        // Hiba esetén üzenet megjelenítése
        echo "Hiba történt a profil törlése közben: " . $conn->error;
    }
}

// Save Profile
if (isset($_POST['save'])) {
    $userId = $_SESSION['RenterID'];
    $firstname = $_POST['firstname'];
    $surename = $_POST['surename'];
    $email = $_POST['email'];
    $telephoneNumber = $_POST['telephoneNumber'];

    $updateQuery = "UPDATE renter SET Firstname = '$firstname', Surename = '$surename', Email = '$email', TelephoneNumber = '$telephoneNumber' WHERE RenterID = '$userId'";
    if ($conn->query($updateQuery) === TRUE) {
        // Sikeres mentés esetén frissítés az adatokkal
        $_SESSION['Firstname'] = $firstname;
        $_SESSION['Surename'] = $surename;
        $_SESSION['Email'] = $email;
        $_SESSION['TelephoneNumber'] = $telephoneNumber;
        // Üzenet a sikeres mentésről
        echo "A profil sikeresen frissült!";
    } else {
        // Hiba esetén üzenet megjelenítése
        echo "Hiba történt a profil mentése közben: " . $conn->error;
    }
}

$sql = "SELECT * FROM settlement";
$result = $conn->query($sql);
$settlementData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $settlementData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/profilCSS.css">
    <link rel="stylesheet" href="css/profilUpdate.css">
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
        <h1 class="asd">Profil Módosítása</h1>

        <h2>Felhasználó adatai:</h2>
        <form action="profilUpdate.php" method="post">
        <p>Vezetéknév: <input type="text" name="firstname" value="{{ renterData.Surname }}"></p>
            <p>Keresztnév: <input type="text" name="surename" value="{{ renterData.FirstName }}"></p>
            <p>Email: <input type="email" name="email" value="{{ renterData.Email }}"></p>
            <p>Telefonszám: <input type="number" name="telephoneNumber" value="{{ renterData.TelephoneNumber }}"></p>

            <!-- Település adatai -->
        <div ng-if="settlementData">
            <h2>Település adatai:</h2>
            <label for="settlement">Válassza ki a települést:</label>
            <select name="settlement" id="settlement">
                <?php foreach ($settlementData as $city): ?>
                    <option value="<?= $city['SettlementName'] ?>|<?= $city['ZipCode'] ?>|<?= $city['county'] ?>">
                        <?= $city['SettlementName'] ?> (<?= $city['ZipCode'] ?>) - <?= $city['county'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

            <button type="submit" name="delete" id="torles">Profil Törlése</button> <!-- A gomb megfelelően van elnevezve -->
            <button type="submit" name="save" id="mentes">Mentés</button> <!-- A gomb megfelelően van elnevezve -->
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
