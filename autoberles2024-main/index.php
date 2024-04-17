<!DOCTYPE html>
<html lang="hu">

<head>
    <!-- Basic page metadata and links to external stylesheets and icons -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JourneyGems</title>
    <link rel="icon" type="image/x-icon" href="Pictures/logoFekete.png">
    <link rel="stylesheet" href="css/style2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <link rel="stylesheet" href="css/style3.css">
</head>

<body id="mainBody">
    <header class="header">
        <!-- Logo and navigation bar for the website -->
        <a href="index.php" class="logo"><img src="Pictures/1-transparent.png" alt="" srcset="" id="logo"></a>

        <!-- Primary navigation -->
        <nav class="navbar">
            <a href="index.php" style="--i:1" class="active">Kezdőlap</a>
            <a href="cars.php" style="--i:2">Autóink</a>
            <a href="profilF.php" style="--i:3">Profil</a>
            <?php
            session_start();
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
        <!-- Social media links with icons from Boxicons -->
        <div class="social-media">
            <a href="https://twitter.com/?lang=hu" target="_blank" style="--i:1"><i class='bx bxl-twitter'></i></a>
            <a href="https://www.facebook.com/" target="_blank" style="--i:2"><i class='bx bxl-facebook'></i></a>
            <a href="https://www.instagram.com/" target="_blank" style="--i:3"><i class='bx bxl-instagram-alt'></i></a>
        </div>
    </header>


    <section class="home">
        <!-- Main banner with a call-to-action button -->
        <div class="home-content">
            <h1>Autókölcsönzés</h1>
            <h3>Baráti áron!</h3>
            <p>Üdvözöljük Önt a minőségi autóbérlés világában. Legyen szó városi kalandokról, üzleti utazásokról vagy családi kirándulásokról, mi állunk rendelkezésére, hogy segítsünk Önnek megtalálni a tökéletes járművet az igényeihez.</p>
            <a href="cars.php" class="btn">Autók megtekintése</a>
        </div>

        <!-- Decorative image with styling in style.css -->
        <div class="home-img">
            <div class="rhombus">
                <img id="car"></img>
                <script>
                    const cars = [
                        "Pictures/car.png",
                        "Pictures/car2.png",
                        "Pictures/car3.png",
                        "Pictures/car7.png",
                        "Pictures/car8.png"
                    ];
                    let runI =
                        Math.floor(
                            Math.random() * cars.length
                        );
                    car.src = cars[runI];
                </script>
            </div>
        </div>
        <!-- Additional decorative element -->
        <div class="rhombus2"></div>
        <!-- Dark mode toggle gomb -->
        <div class="darkmode-toggle" onclick="toggleDarkMode()">
            🌓
        </div>
    </section>


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