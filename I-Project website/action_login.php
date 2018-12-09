<?php


include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
require_once 'recources/php/breadcrumb.php';

$username = $_POST['username'];
$password = $_POST['password'];
$passwordHash = md5($password);
$_SESSION['message'] = 'wrong input';

$data = selectWhere('*','Gebruiker','Gebruikersnaam=?', [$username]); //database tabel
var_dump($data);
session_destroy();
if($data[0]['wachtwoord'] == $passwordHash ){
echo "succesfull";
session_start();
$_SESSION['username'] = $username;
$_SESSION['role'] = $data[0]['role'];
header('location: home.php');
} else {
echo "Verkeerde gegevens";
header('location: login.php');
}
