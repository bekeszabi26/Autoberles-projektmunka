<?php
session_start();
include_once "config.php";
//a linkben utazó adatból eltároljuk a kiválasztott autó id-jét
if(isset($_GET['carId'])){
    $carId = $_GET['carId'];
    //a tesztelés során ellenőriztük, sikerült e eltárolni a változóba az adatot
    //var_dump($carId);
    // Lekérdezés az adatbázisból
    $sql = "SELECT car.CarID, car.Description, car.Picture, car.Color, car.Engine, car.Performance, car.Seats, car.ProductionYear, car.AirConditioning, car.Deposit, car.PricePerDay, brand.BrandName, carmodel.CarModelName, bodytype.BodyTypeName, fueltype.FuelName, drivetype.DriveName, transmissiontype.TransmissionType
            FROM car
            JOIN carmodel ON car.ModelID = carmodel.ModelID
            JOIN brand ON carmodel.BrandID = brand.BrandID
            JOIN bodytype ON car.BodyTypeID = bodytype.BodyTypeID
            JOIN fueltype ON car.FuelID = fueltype.FuelID
            JOIN drivetype ON car.DriveID = drivetype.DriveID
            JOIN transmissiontype ON car.TransmissionID = transmissiontype.TransmissionID WHERE CarID = $carId";
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