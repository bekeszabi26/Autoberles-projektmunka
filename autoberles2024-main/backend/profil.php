<?php
session_start();
include_once "config.php";

// Ellenőrizze, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['RenterID'])) {
    header("Location: login.php");
    exit();
}

$RenterID = $_SESSION['RenterID'];

// Renter, settlement és reservation adatainak lekérdezése
$sql = "SELECT renter.*, settlement.SettlementName, settlement.ZipCode, settlement.county, reservation.ReservationID, reservation.CarID, reservation.StartingDay, reservation.EndingDay
        FROM renter
        LEFT JOIN settlement ON renter.SettlementID = settlement.SettlementID
        LEFT JOIN reservation ON renter.RenterID = reservation.RenterID
        WHERE renter.RenterID = $RenterID";

$result = mysqli_query($conn, $sql);

// Adatok rendezése egy asszociatív tömbbe
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data['renterData'] = array(
        'FirstName' => $row['Firstname'],
        'Surname' => $row['Surename'],
        'Email' => $row['Email'],
        'TelephoneNumber' => $row['TelephoneNumber']
    );

    if (!empty($row['SettlementName'])) {
        $data['settlementData'] = array(
            'SettlementName' => $row['SettlementName'],
            'ZipCode' => $row['ZipCode'],
            'County' => $row['county']
        );
    }

    if (!empty($row['ReservationID'])) {
        $data['reservationData'][] = array(
            'ReservationID' => $row['ReservationID'],
            'CarID' => $row['CarID'],
            'StartingDay' => $row['StartingDay'],
            'EndingDay' => $row['EndingDay']
        );
    }
}

// JSON válasz küldése
header('Content-Type: application/json');
echo json_encode($data);

