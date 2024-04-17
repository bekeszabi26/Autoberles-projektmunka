<?php
include_once "backend/config.php";

?>

<body>
<?php
include_once "navbar.php"; 
?>
    <h1>Autó foglalás</h1>

    <form method="post" action="">
        <!-- Autó kiválasztása -->
        <label for="carID">Autó kiválasztása:</label>
        <select id="carID" name="carID">
            <?php
            $carQuery = "SELECT car.CarID, CONCAT(brand.BrandName, ' ', carmodel.CarModelName, ' (', car.ProductionYear, ')') AS CarInfo
                 FROM car
                 JOIN carmodel ON car.ModelID = carmodel.ModelID
                 JOIN brand ON carmodel.BrandID = brand.BrandID";
            $resultCar = mysqli_query($conn, $carQuery);

            while ($rowCar = mysqli_fetch_assoc($resultCar)) {
                echo "<option value='{$rowCar['CarID']}'>{$rowCar['CarInfo']}</option>";
            }
            ?>
        </select><br>

        <!-- Foglalási időszak -->
        <label for="startingDay">Foglalás kezdete:</label>
        <input type="date" id="startingDay" name="startingDay" min="<?php echo date('Y-m-d'); ?>" required><br>

        <label for="endingDay">Foglalás vége:</label>
        <input type="date" id="endingDay" name="endingDay" min="<?php echo date('Y-m-d'); ?>" required><br>

        <button type="submit" name="reserve">Foglalás</button>
    </form>
    <script src="../js/checkDate.js"></script>
</body>

</html>