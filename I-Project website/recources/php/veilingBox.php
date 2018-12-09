<?php
  require'functions/database/db_Settings.php';
  include 'recources/js/countdownTimer.js';


  function veilingItemBox($itemNr,$clockNr){

    $naam = 'NOITEMFOUND';
    $bod = 0;
    $rubriek = 'NOVALUEFOUND';
    $startPrijs = 0;
    $itemUrl = '#';


    $sql=$GLOBALS['con']->query(
      "select R.rubrieknaam, V.title, V.verkopprijs, V.Startprijs, V.looptijdeindetijdstip, V.looptijdeindeDag
      from Voorwerp V left outer join Voorwerp_in_Rubriek ViR on v.voorwerpnummer = vir.voorwerpnummer
	left outer join Rubriek R on vir.Rubriek_op_Laagste_Niveau = r.rubrieknummer where v.voorwerpnummer = ".$itemNr);
      // V.looptijdeindeDag > CONVERT (date, SYSDATETIME()) AND
    $row=$sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $item) {
      $naam = $item['title'];
      $startPrijs = $item['Startprijs'];
      $bod = $item['verkopprijs'];

      $rubriek = $item['rubrieknaam'];
      $itemUrl = 'item.php?Id='.$itemNr;

      if($bod < $startPrijs){
        $bod = $startPrijs;
      }
    }

    if($naam != 'NOITEMFOUND'){

      $thumbnail;

      if(file_exists("recources/images/veiling_items/$itemNr/vi-$itemNr-0.jpg")){

        $thumbnail = "recources/images/veiling_items/$itemNr/vi-$itemNr-0.jpg";
      }else{
        $thumbnail = "http://iproject11.icasites.nl/pics/dt_1_".$itemNr.".jpg";
      }


      $veilingBox =
      '<a href="'.$itemUrl.'" class="vib-href">
        <div class="vib-HoverGlow"></div>
        <div class="veilingItemBox">
          <div class="vib-Rubriek">
            <span class="badgeGreen">'.$rubriek.'</span>
          </div>
          <div class="vib-NaamBox">
            <div class="vib-NaamBoxBackGround">
              <p class="vib-Naam"><span>'.$naam.'</span></p>
            </div>
          </div>
          <div class="vib-Foto" style="background-image: url('.$thumbnail.')"></div>
          <p class="vib-Bod">Hoogstebod: &euro;'.$bod.'</p>
          <div class="vib-CountdownContainer">
            <div class="vib-CountdownItem">
              <p class="vib-CountdownNummer" id="cd_Days'.$clockNr.'">'.$clockNr.'</p>
              <p class="vib-CountdownTekst">Dag(en)</p>
            </div>
            <div class="vib-CountdownItem" style="width: 10px;">
              <p class="vib-CountdownNummer">&nbsp;</p>
            </div>
            <div class="vib-CountdownItem">
              <p class="vib-CountdownNummer" id="cd_Hours'.$clockNr.'">-</p>
              <p class="vib-CountdownTekst">Uur</p>
            </div>
            <div class="vib-CountdownItem" style="width: 10px;">
              <p class="vib-CountdownNummer">:</p>
            </div>
            <div class="vib-CountdownItem">
              <p class="vib-CountdownNummer" id="cd_Minutes'.$clockNr.'">-</p>
              <p class="vib-CountdownTekst">Min</p>
            </div>
            <div class="vib-CountdownItem" style="width: 10px;">
              <p class="vib-CountdownNummer">:</p>
            </div>
            <div class="vib-CountdownItem">
              <p class="vib-CountdownNummer" id="cd_Seconds'.$clockNr.'">-</p>
              <p class="vib-CountdownTekst">Sec</p>
            </div>
          </div>
          <div class="vib-MeerInfo">
            <p>Klik voor meer informatie</p>
          </div>
        </div>
      </a>';
      echo $veilingBox;

    }
  }
?>
