<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['RenterID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['send'])) {
   
    // További adatok beolvasása az űrlapról
    $newFirstname = strip_tags(ucwords(strtolower(trim($_POST['newFirstname']))));
    $newSurename = $_POST['newSurename'];
    $newTelephoneNumber = $_POST['newTelephoneNumber'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    // Változók vizsgálata
    if (empty($newFirstname) && empty($newSurename))
        $hibak[] = "Nem adtál meg nevet!";
    if (!empty($newTelephoneNumber) && strlen($newTelephoneNumber) < 9)
        $hibak[] = "Rossz mobil számot adtál meg!";
    if (!empty($newEmail) && !filter_var($email, FILTER_VALIDATE_EMAIL))
        $hibak[] = "Rossz e-mail címet adtál meg!";

    if (isset($hibak)) {
        $kimenet = "<ul>\n";
        foreach ($hibak as $hiba) {
            $kimenet .= "<li>{$hiba}</li>\n";
        }
        $kimenet .= "</ul>\n";
    } else {

        $updateRenterQuery = "UPDATE renter 
            SET Firstname = '$newFirstname', Surename = '$newSurename', 
                TelephoneNumber = '$newTelephoneNumber', Email = '$newEmail', Password = '$newPassword' 
            WHERE RenterID = $RenterID";

        $resultUpdateRenter = mysqli_query($conn, $updateRenterQuery);

        if ($resultUpdateRenter) {
            echo "Sikeres frissítés a renter táblában.";
        } else {
            echo "Hiba a renter táblában történő frissítés során: " . mysqli_error($conn);
        }
    }
// További adatok beolvasása az űrlapról (cím frissítése)
$newStreet = $_POST['newStreet'];
$newAddress = $_POST['newAddress'];

// Frissítés a renter táblában (cím frissítése)
$updateAddressQuery = "UPDATE renter 
                      SET Street = '$newStreet', Address = '$newAddress' 
                      WHERE RenterID = $RenterID";

$resultUpdateAddress = mysqli_query($conn, $updateAddressQuery);

if ($resultUpdateAddress) {
    echo "Sikeres frissítés a cím mezőkben.";
} else {
    echo "Hiba a cím mezők frissítése során: " . mysqli_error($conn);
}

}else{
    $RenterID = $_SESSION['RenterID'];
    $sql = "SELECT *
        FROM renter
        WHERE RenterId = {$RenterID}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $firstname = $row['Firstname'];
    $surename = $row['Surename'];
    $mobil = $row['TelephoneNumber'];
    $email = $row['Email'];
    $password=$row['Password'];
    $street = $row['Street'];
    $address = $row['Address'];
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter Profil Frissítés</title>
</head>

<body>
    <h1>Renter Profil Frissítés</h1>

    <form method="post" action="">
        <!-- Űrlapmezők adatainak előzetes kitöltése a jelenlegi adatokkal -->
        <label for="newFirstname">First Name:</label>
        <input type="text" id="newFirstname" name="newFirstname" value="<?php echo $firstname; ?>"><br>

        <label for="newSurename">Surename:</label>
        <input type="text" id="newSurename" name="newSurename" value="<?php echo $surename ?>"><br>

        <label for="newTelephoneNumber">Telephone Number:</label>
        <input type="text" id="newTelephoneNumber" name="newTelephoneNumber"
            value="<?php echo $mobil; ?>"><br>

        <label for="newEmail">Email:</label>
        <input type="email" id="newEmail" name="newEmail" value="<?php echo $email; ?>"><br>

        <label for="newPassword">Password:</label>
        <input type="password" id="newPassword" name="newPassword" value="<?php echo $password; ?>"><br>

        <!-- Cím mezők -->
        <!-- Település mező -->
        <label for="newSettlementId">Settlement:</label>
        <select id="newSettlementId" name="newSettlementId">
            <?php
            // Betöltjük a településeket a legördülő listába
            $sqlSettlements = "SELECT * FROM settlement";
            $resultSettlements = mysqli_query($conn, $sqlSettlements);

            while ($settlement = mysqli_fetch_assoc($resultSettlements)) {
                $selected = ($settlement['SettlementId'] == $settlementId) ? "selected" : "";
                echo "<option value='{$settlement['SettlementId']}' $selected>{$settlement['SettlementName']}</option>";
            }
            ?>
        </select><br>

        <label for="newAddress">Address:</label>
        <input type="text" id="newAddress" name="newAddress" value="<?php echo $row['Address']; ?>"><br>

        <button type="submit" name="send">Frissítés</button>
    </form>
</body>

</html>