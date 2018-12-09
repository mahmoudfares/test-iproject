<?php
require 'recources/php/functions/functie.php';
//include 'action_login.php';
session_start();
$username = $_SESSION['username'];

$sql =  $GLOBALS['con']->query("UPDATE gebruiker SET verkoper = 1 WHERE gebruikersnaam = ".$username);
//$sql->execute($values);

header("location:login.php" );
?>