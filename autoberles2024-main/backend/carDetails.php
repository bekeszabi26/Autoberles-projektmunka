<?php
session_start();
include_once "config.php";
//a linkben utazó adatból eltároljuk a kiválasztott autó id-jét
if(isset($_GET['carId'])){
    $carId = $_GET['carId'];
    //a tesztelés során ellenőriztük, sikerült e eltárolni a változóba az adatot
    //var_dump($carId);
    // Lekérdezés az adatbázisból
    $sql = "SELECT * FROM car WHERE CarID = $carId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $carDetails = mysqli_fetch_assoc($result);
        echo json_encode($carDetails, JSON_PRETTY_PRINT);} else {
            echo json_encode(["error" => "Nem létező carId"]);
        }
    
        // Kapcsolat bezárása
        mysqli_close($conn);
    } else {
        echo json_encode(["error" => "Nem létező carId"]);
    }
?>