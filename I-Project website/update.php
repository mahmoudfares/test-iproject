<?php
include'recources/php/head.php';
require'recources/php/functions/functie.php';

if(isset($_GET['rubriek'])){
  $desired = array($_GET['rubriek']); 
  updateWhere(rubriek, $desired, $_GET['rubrieknummer'])

?>