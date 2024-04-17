<?php
// Indítjuk a session-t
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if(isset($_SESSION['RenterID'])) {
    // Ha be van jelentkezve, akkor töröljük a session változókat
    session_unset();

    // Lecsatoljuk a session-t
    session_destroy();

    // Átirányítjuk a felhasználót a kezdőlapra vagy egy másik oldalra
    header("Location: ../index.php");
    exit();
} else {
    // Ha a felhasználó nincs bejelentkezve, akkor nem csinálunk semmit
    // és átirányítjuk a felhasználót a kezdőlapra vagy egy másik oldalra
    header("Location: ../index.php");
    exit();
}
?>