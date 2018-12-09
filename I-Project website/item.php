<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
require_once 'recources/php/breadcrumb.php';

$itemNr = $_GET['Id'];

$itemNaam = 'NOITEMFOUND';
$itemBod = 'GEENBODGEVONDEN';
$itemRubriek = '';
$itemBeschrijving = '';
$itemVerkoper = '';
$itemEindDatum = '';
$itemEindTijd = '';


$sql=$GLOBALS['con']->query(
  "select *
  from Voorwerp
  where voorwerpnummer = ".$itemNr);
$vItem=$sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($vItem as $item) {
  $itemNaam = $item['title'];
  $itemBod = $item['verkopprijs'];
  // $itemRubriek = $item['rubrieknaam'];
  $itemBeschrijving = $item['beschrijving'];
  $itemVerkoper = $item['verkoper'];
  $itemEindDatum = $item['looptijdeindeDag'];
  $itemEindTijd = $item['looptijdeindetijdstip'];
}

$items = selectWithJoin('*','Gebruiker G','Voorwerp V','v.verkoper = g.Gebruikersnaam',
'V.voorwerpnummer ='.$itemNr);
$rubriek = selectWithJoin('*','rubriek R','Voorwerp_in_Rubriek VR','R.rubrieknummer = VR.Rubriek_op_Laagste_Niveau',
'VR.voorwerpnummer = '.$itemNr);
$breadcrumbs[] = array(
  'link'=>'veilingen.php?search_text=&min_price=&max_price=&rubriek='.$rubriek[0]['rubrieknummer'].'&amp;search=',
  'title'=>$rubriek[0]['rubrieknaam']
);
$breadcrumbs[] = array(
  'link'=>'#',
  'title'=>$items[0]['title']
);

if(isset($_POST['bod_plaatsen']) && selectStartprijsWhere($itemNr) <= $_POST['bod_plaatsen'] ){
 $tabel = 'Bod';
 $bodkolomen = 'bodbedrag ,bodDag, gebruiker, bodTijdstip, Voorwerp';
 $waarde = array($_POST['bod_plaatsen'],$_SESSION['username'],$itemNr);
 $bodplaatsen = insert( $tabel,$bodkolomen ,'?,CONVERT (date, SYSDATETIME()),?,CONVERT (time, SYSDATETIME()) ,?',$waarde);
 // zet verkoop prijs op hoogste bod
$sql =  $GLOBALS['con']->prepare("update Voorwerp set verkopprijs = ? where voorwerpnummer = ? AND ? > verkopprijs AND ? > Startprijs");
    $sql->execute(array($_POST['bod_plaatsen'],$itemNr,$_POST['bod_plaatsen'],$_POST['bod_plaatsen']));

}

$sqlBids=$GLOBALS['con']->query("select top(5) * from Bod where Voorwerp = $itemNr order by bodbedrag desc");
$topFiveBids=$sqlBids->fetchAll(PDO::FETCH_ASSOC);



$textStartPrice = "Startprijs: &euro;".$items[0]['Startprijs'];
if(empty($topFiveBids[0]['Bodbedrag'])){
    $textHighestBid = "";
}else{
  $textHighestBid = " | Hoogstebod: &euro;".$topFiveBids[0]['Bodbedrag'];
}



echoHead($itemNaam." | Eenmaal Andermaal")
?>

<body>
  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>
  <?php include 'recources/php/navbar.php' ?>
  <div class="itemPageContent">
    <?php showBreadcrumb($breadcrumbs);?>
    <div class="veilingItemPage">
      <h2><?=$itemNaam?></h2>
      <p class="underTitleText">Aangeboden door: <?=$itemVerkoper?></p>
      <div class="vip-Foto-CountdownBox">
        <!-- <img src="recources/images/veiling_items/<?=$itemNr?>/vi-<?=$itemNr?>-0.jpg" width="100%"> -->


        <?php include "recources/php/pictureCarousel.php";
        echo"
       <script>
       var countDownDate = [];
       </script>";
        $clockNr = 0;
        $date =$item['looptijdeindeDag'].'T'.$item['looptijdeindetijdstip'];

        echo"
          <script>
          countDownDate.push(new Date('$date').getTime());
          </script>";
        ?>


        <div class="vib-CountdownContainer">
          <div class="vib-CountdownItem">
            <p class="vib-CountdownNummer" id="cd_Days0">-</p>
            <p class="vib-CountdownTekst">Dag(en)</p>
          </div>
          <div class="vib-CountdownItem" style="width: 10px;">
            <p class="vib-CountdownNummer">&nbsp;</p>
          </div>
          <div class="vib-CountdownItem">
            <p class="vib-CountdownNummer" id="cd_Hours0">-</p>
            <p class="vib-CountdownTekst">Uur</p>
          </div>
          <div class="vib-CountdownItem" style="width: 10px;">
            <p class="vib-CountdownNummer">:</p>
          </div>
          <div class="vib-CountdownItem">
            <p class="vib-CountdownNummer" id="cd_Minutes0">-</p>
            <p class="vib-CountdownTekst">Min</p>
          </div>
          <div class="vib-CountdownItem" style="width: 10px;">
            <p class="vib-CountdownNummer">:</p>
          </div>
          <div class="vib-CountdownItem">
            <p class="vib-CountdownNummer" id="cd_Seconds0">-</p>
            <p class="vib-CountdownTekst">Sec</p>
          </div>
        </div>
        <div class="vip-countdownContainer">
          <p class="vip-CountdownTekst"><?=$textStartPrice.$textHighestBid?></p>
        </div>
        </img>

      </div>
      <div class="vip-bid">
        <script type="text/javascript" src="recources\js\errormessage.js"></script>
        <form action="item.php?Id=<?=$itemNr?>" method="post">
        <div class="form-group">
        <input type="number" pattern="[0-9]" placeholder="plaats uw bod" name="bod_plaatsen" required>
		<?php

		//if(CONVERT (date, SYSDATETIME()) < selectEindeDagWhere() && CONVERT (time, SYSDATETIME()) < selectEindeTijdWhere()){
			if(getDbDate() > selectEindeDagWhere($itemNr) && getDbTime() > selectEindeTijdWhere($itemNr)){
               echo '<button type="button" class="btn buttonRed" >Veiling gesloten </button><p>';
			} else{echo '<button type="submit" class="btn buttonGreen" >plaats bod</button>';

			}
				 ?>
				 </p>
               </div>
        </form>

      </div>
      <div>
      <!-- <p style="font-size: 30px; font-weight: 300;">Hoogstebod: &euro;<?= selecthoogsteWhere($itemNr)?></p>
	  <p style="font-size: 30px; font-weight: 300;"> -->
	  <?php if(isset($_POST['bod_plaatsen']) && selectStartprijsWhere($itemNr) <= $_POST['bod_plaatsen'] ){ echo "UW BOD IS GEPLAATST";}
	  else if(isset($_POST['bod_plaatsen'])){echo "HELAAS, UW BOD IS AFGEKEURD";}?></p>
      <div class="vip-description">
        <h3>Beschrijving</h3>
        <p class="vip-description-text"><?=$itemBeschrijving?></p>
      </div>
    </div>

    </div>
  </div>
<?php include 'recources/php/footer.php';
include 'recources/js/countdownTimer.js';?>
