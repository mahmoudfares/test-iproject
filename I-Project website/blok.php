<?php
require_once'recources/php/functions/functie.php';
session_start();
if (isset($_SESSION['role']) && isset($_GET['request'])&& isset($_GET['id']) && $_SESSION['role']==1){
    $tablename = $_GET['request'];
    $coondition = $_GET['id'];
    if($tablename == 'Voorwerp'){
      $sql = $GLOBALS['con']->prepare("update $tablename set velingsGesloten = 1 where voorwerpnummer = ? ");
      $sql->execute([$coondition]);
      header('location:adminpage.php');
    }elseif ($tablename == 'Gebruiker') {
      $coondition = '%'.$coondition.'%';
      $sql = $GLOBALS['con']->prepare("update $tablename set role =  2 where Gebruikersnaam like ?");
      $sql->execute([$coondition]);
      header('location:adminpage.php');
    }
}else {
  header('location:index.php');
}
?>
