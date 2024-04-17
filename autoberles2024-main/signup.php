<?php
session_start();
if (isset ($_SESSION['user_id'])) {//ha a user be van lépve
    header("location:index.php");
}

include_once "head.php";

// Adatbázis kapcsolat létrehozása
$servername = "localhost";
$username = "root"; // Felhasználónév
$password = ""; // Jelszó
$database = "autoberlespm"; // Adatbázis neve

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die ("Kapcsolódási hiba: " . $conn->connect_error);
}

// Város nevek lekérése az adatbázisból
$sql = "SELECT SettlementID, SettlementName, ZipCode FROM settlement ORDER BY SettlementName ASC";
$result = $conn->query($sql);

?>

<body>
    <div class="wrapper">
        <section class="form signup">
            <header>
                Regisztráció
            </header>
            <form action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="registrationForm">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>Vezetéknév:</label>
                        <input type="text" placeholder="Vezetéknév" name="Surename" id="Surename" required>
                    </div>
                    <div class="field input">
                        <label>Keresztnév:</label>
                        <input type="text" placeholder="Keresztnév" name="Firstname" id="Firstname" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Telefonszám:</label>
                    <input type="tel" placeholder="Telefonszám" name="TelephoneNumber" id="TelephoneNumber" required>
                </div>
                <div class="field input">
                    <label>E-mail:</label>
                    <input type="email" name="Email" placeholder="E-mail cím" id="Email" required>
                </div>
                <div class="field input">
                    <label>Jelszó:</label>
                    <input type="password" name="Password" placeholder="Jelszó" id="Password" required><i
                        class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <label>Jelszó megerősítése:</label>
                    <input type="password" name="passwordagain" placeholder="Jelszó" id="passwordagain" required><i
                        class="fas fa-eye"></i>
                </div>
                <div class="field">
                    <label>Település:</label>
                    <select name="city" id="city" required>
                        <option value="" disabled selected>Válasszon települést:</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['SettlementID'] . "'>" . $row['SettlementName'] . " (" . $row['ZipCode'] . ")</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="field button">
                    <input type="submit" value="Tovább a főoldalra">
                </div>
            </form>
            <div class="link">Ha már van regisztrációja, lépjen be: <a href="login.php">Belépés</a></div>
        </section>
    </div>

    <script src="js/pass-show-hide.js"></script>
    <script src="js/signup.js"></script>
</body>

</html>

<?php
// Adatbázis kapcsolat bezárása
$conn->close();
?>