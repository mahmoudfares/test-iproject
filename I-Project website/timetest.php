<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
echoHead("Timetest | Eenmaal Andermaal");



$sql=$GLOBALS['con']->query(
  "select R.rubrieknaam, V.title, V.verkopprijs, V.Startprijs, V.looptijdeindetijdstip, V.looptijdeindeDag
  from Rubriek R join Voorwerp_in_Rubriek ViR on R.rubrieknummer = ViR.Rubriek_op_Laagste_Niveau join Voorwerp V on ViR.voorwerpnummer = V.voorwerpnummer");
$row=$sql->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $item) {
  $naam = $item['title'];
  $startPrijs = $item['Startprijs'];
  $bod = $item['verkopprijs'];

  $rubriek = $item['rubrieknaam'];
  $date = $item['looptijdeindeDag'];
  $time = $item['looptijdeindetijdstip'];
  $hour = floor(($time -  % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  echo $naam."|".$date."|".$time." - ";
}
?>

<body>
  <p>1</p>
</body>
