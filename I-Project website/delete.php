<?php
include'recources/php/head.php';
require'recources/php/functions/functie.php';
$seconds = 2;
// header("refresh:$seconds; url=Admin.php");
if(isset($_GET['rubriek'])){
  $desired = array($_GET['rubriek']);
  delete('rubriek','rubriek = ?',$desired);
  Echo delete('rubriek','rubrieknummer = ?',$desired); ;
}
elseif(isset($_GET['voorwerp'])){
  $desired = array($_GET['voorwerp']);
  Echo delete('voorwerp','voorwerpnummer = ?',$desired);
}
?>
<!-- <div class="alert alert-success">
    <strong>Success!</strong> Een account is verwijderd!, U wordt over <?=$seconds?> Seconde teruggestuurd.
</div> -->
