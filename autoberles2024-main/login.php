<?php 
session_start();
if(isset($_SESSION['RenterID'])){
    header("location:index.php");
}
?>
<?php include_once "head.php"; ?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>
                Belépés
            </header>
            <form action="login_process.php" method="post">
                <div class="error-txt"><?php if(isset($_SESSION['login_error'])){ echo $_SESSION['login_error']; } ?></div>
                
                <div class="field input">
                    <label>E-mail:</label>
                    <input type="email" placeholder="E-mail cím" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label>Jelszó:</label>
                    <input type="password" placeholder="Jelszó" name="password" id="password" required>
                    <i class="fas fa-eye"></i>
                </div>
                    
                <div class="field button">
                    <input type="submit" value="Belépés">
                </div>
                
            </form>
            <div class="link">Ha még nincs regisztrációja: <a href="signup.php">Regisztráció</a></div>
        </section>
    </div>
    <script src="js/pass-show-hide.js"></script>
    <script src="js/login.js"></script>
</body>

</html>
