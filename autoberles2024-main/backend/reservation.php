<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['RenterID'])) {
    header("Location: login.php");
    exit();
}

$RenterID = $_SESSION['RenterID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve'])) {

    $carID = $_POST['carID'];
    $startingDay = $_POST['startingDay'];
    $endingDay = $_POST['endingDay'];

    // Ellenőrzés, hogy a foglalás dátumai helyesek-e
    if (strtotime($endingDay) <= strtotime($startingDay)) {
        echo "Hibás foglalási időszak!";
    } else {
        // Ellenőrizzük, hogy a kiválasztott időszakban szabad-e az autó
        $checkAvailabilityQuery = "SELECT * FROM reservation
                                    WHERE CarID = $carID
                                    AND (
                                        (StartingDay BETWEEN '$startingDay' AND '$endingDay')
                                        OR (EndingDay BETWEEN '$startingDay' AND '$endingDay')
                                    )";
        $resultCheckAvailability = mysqli_query($conn, $checkAvailabilityQuery);

        if (mysqli_num_rows($resultCheckAvailability) > 0) {
            echo "Az autó ezen időszakban már foglalt!";
        } else {
            //random id generálása
            function generateUniqueReservationId($conn) {
                // Generálunk egy random számot
                $uniqueReservartionId = rand(100000, 999999);
                   return $uniqueReservartionId;
               }
            // Unikális azonosító generálása
            $ReservationId = generateUniqueReservationId($conn);
            // Foglalás rögzítése az adatbázisban
            $reserveQuery = "INSERT INTO reservation (ReservationId, RenterID, CarID, StartingDay, EndingDay)
                             VALUES ($ReservationId, $RenterID, $carID, '$startingDay', '$endingDay')";
            $resultReserve = mysqli_query($conn, $reserveQuery);

            if ($resultReserve) {
                echo "Foglalás sikeres!";
                header("Location: profil.php");
            } else {
                echo "Hiba a foglalás során: " . mysqli_error($conn);
            }
        }
    }
}
?>