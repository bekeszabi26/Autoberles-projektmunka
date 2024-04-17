<?php
session_start();
include_once "config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$writtenpass = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM renter WHERE Email = '{$email}'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

if ($row) {
    $hashedPassword = $row['Password'];
    
    // jelszó ellenőrzés
    if (password_verify($writtenpass, $hashedPassword)) {
        
        $_SESSION['RenterID'] = $row['RenterID'];
        echo "success";
    } else {
        $_SESSION['login_error'] = "Helytelen jelszót adott meg!";
        header("location: login.php");
    }
} else {
    // ha nincs ilyen felhasználó
    $_SESSION['login_error'] = "Helytelen bejelentkezési adatok!";
    header("location: login.php");
}

