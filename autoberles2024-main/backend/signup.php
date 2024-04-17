<?php
session_start();
include_once "config.php";

$Surename = mysqli_real_escape_string($conn, $_POST['Surename']);
$Firstname = mysqli_real_escape_string($conn, $_POST['Firstname']);
$TelephoneNumber = mysqli_real_escape_string($conn, $_POST['TelephoneNumber']);
$Email = mysqli_real_escape_string($conn, $_POST['Email']);
$Password = mysqli_real_escape_string($conn, $_POST['Password']);
$passwordagain = mysqli_real_escape_string($conn, $_POST['passwordagain']);
$chosenCityID = $_POST['city'];

/**vissza is kell tudni fejteni belépésnél, így önmagában nem fog engedni újra belépni*/
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

if (!empty($Surename) && !empty($Firstname) && !empty($Email) && !empty($hashedPassword) && $hashedPassword != $passwordagain) {
    // e-mail cím érvényes formátumának ellenőrzése
    if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        // ellenőrzés, hogy létezik-e már ez a mail cím
        $sql = mysqli_query($conn, "SELECT Email FROM renter WHERE Email = '{$Email}'");

        if ($sql !== false && mysqli_num_rows($sql) > 0) {
            echo "$Email - már létező e-mail cím!";
        } else {
            // adatok beszúrása az adatbázisba
            $sql2 = mysqli_query($conn, "INSERT INTO renter (Surename, Firstname, TelephoneNumber, Email, Password, SettlementID)
            VALUES ('{$Surename}', '{$Firstname}', '{$TelephoneNumber}', '{$Email}', '{$hashedPassword}', '{$chosenCityID}')");
            if ($sql2) {
                $sql3 = mysqli_query($conn, "SELECT * FROM renter WHERE Email = '{$Email}'");

                if ($sql3 !== false && mysqli_num_rows($sql3) > 0) {
                    $row = mysqli_fetch_assoc($sql3);
                    $_SESSION['RenterID'] = $row['RenterID'];
                    echo "success";
                }
            } else {
                echo "Valami hiba történt!";
            }
        }
    } else {
        echo "Az e-mail cím érvénytelen!";
    }
} else {
    echo "Minden mezőt ki kell töltenie vagy a jelszavak nem egyeznek!";
}


