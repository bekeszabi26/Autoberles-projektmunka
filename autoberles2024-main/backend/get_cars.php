<?php
// Kapcsolódás az adatbázishoz
include "config.php";

// Lekérdezés az autókhoz
$query = "SELECT car.CarID, car.Description, car.Picture, car.Color, car.Engine, car.Performance, car.Seats, car.ProductionYear, car.AirConditioning, car.Deposit, car.PricePerDay, brand.BrandName, carmodel.CarModelName, bodytype.BodyTypeName, fueltype.FuelName, drivetype.DriveName, transmissiontype.TransmissionType
            FROM car
            JOIN carmodel ON car.ModelID = carmodel.ModelID
            JOIN brand ON carmodel.BrandID = brand.BrandID
            JOIN bodytype ON car.BodyTypeID = bodytype.BodyTypeID
            JOIN fueltype ON car.FuelID = fueltype.FuelID
            JOIN drivetype ON car.DriveID = drivetype.DriveID
            JOIN transmissiontype ON car.TransmissionID = transmissiontype.TransmissionID";
$result = mysqli_query($conn, $query);

// Ellenőrizd, hogy van-e eredmény
if ($result && mysqli_num_rows($result) > 0) {
    // Hoz létre egy üres tömböt az autók tárolására
    $cars = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Minden autó adatait hozzáadja a tömbhöz
        $cars[] = $row;
        //adatok ellenőrzése
        //var_dump($cars);
    }
    // Visszaadja az autók tömböt JSON formátumban
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($cars, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    // Ha nincs eredmény, akkor hibát ad vissza
    echo json_encode(array("message" => "Nincs találat az adatbázisban."));
}

// Kapcsolat bezárása
mysqli_close($conn);
?>
