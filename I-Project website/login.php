<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
require_once 'recources/php/breadcrumb.php';
echoHead("Inloggen | Eenmaal Andermaal");

?>

<body>
<?php include 'recources/php/navbar.php' ?>
<div class="pageContent">
    <div class="adminLoginPage">
        <h2 style="text-align:center;">Gebruiker login</h2>
        <p class="wrongInput" style="text-align:center;"><?php
            if (isset($_GET['error'])) {
                echo "Onjuiste gegevens";
            }else{
              echo '';
            }
            ?></p>
        <div class="adminLoginFormBox">
            <form action="action_login.php" method="post">
                Gebruikersnaam<br>
                <input type="text" name="username"><br><br>
                Wachtwoord<br>
                <input type="password" name="password"><br><br>
                <input class="loginButton"type="submit" value="Login">
                <p>Geen account? Klik <a href="registreren.php">HIER</a></p>
            </form>
        </div>
    </div>

</div>

<?php
    include 'recources/php/footer.php';
?>
