<?php

// Kapcsolódás az adatbázishoz
include_once "../config.php";

// Beolvasás és dekódolás a JSON fájlból
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// SQL utasítás előkészítése és végrehajtása
foreach ($data as $row) {
    $SettlementID = $row['id'];
    $SettlementName = $row['nev'];
    $ZipCode = $row['irsz'];
    $county = $row['megye'];

    $sql = "INSERT INTO settlement (SettlementID, SettlementName, ZipCode, county) 
            VALUES ('$SettlementID', '$SettlementName', '$ZipCode', '$county')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Kapcsolat bezárása
$conn->close();