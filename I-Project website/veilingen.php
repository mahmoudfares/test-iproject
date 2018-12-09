<?php

include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
include 'recources/php/functions/filterItems.php';
$autoincrement = 0;
echoHead("Veilingen | Eenmaal Andermaal");
  if(isset($_GET['search'])){
    if(isset($_GET['min_price'])&&isset($_GET['max_price'])&&isset($_GET['rubriek'])&&isset($_GET['search_text'])){
      $minPrice = $_GET['min_price'];
      $maxPrice = $_GET['max_price'];
      $rubriek = $_GET['rubriek'];
      $searchText = $_GET['search_text'];
      if(empty($_GET['min_price'])||$minPrice<0){
        $minPrice = 0;
      }
      if(empty($_GET['max_price'])){
        $maxPrice = 99999999;
      }
      if(!is_numeric($rubriek) || $rubriek < 0){
        $sign = ">=";
      }
      else{
        $sign = "=";
      }
      $values = [];
      $searchText = trim($searchText);
      $searchText = explode(' ',$searchText);
      $aantal = '';
      foreach ($searchText as  $text) {
        $values[] = '%'.$text.'%';
        $aantal .= "V.title like ? and ";
      }
      $aantal = rtrim($aantal,'and ');
      $items = selectWithJoin('top (500) *','Voorwerp V ',' Voorwerp_in_Rubriek VIR','V.voorwerpnummer = VIR.voorwerpnummer',
      "VIR.Rubriek_op_Laagste_Niveau $sign $rubriek AND (V.verkopprijs BETWEEN $minPrice AND $maxPrice or v.verkopprijs is null) AND ($aantal) AND V.veilingGesloten = 0 order by v.looptijdeindeDag, v.looptijdeindetijdstip",
      $values);
    }
    else{
      $items = selectWhereOrderBy('top (500) *','Voorwerp',"veilingGesloten = 0",'looptijdeindeDag, looptijdeindetijdstip');
    }
  }
  else{
    $items = selectWhereOrderBy('top (500) *','Voorwerp',"veilingGesloten = 0",'looptijdeindeDag, looptijdeindetijdstip');
  }
?>

<body>

  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>
  <?php include 'recources/php/navbar.php';
  if(isset($_GET['rubriek'])){
    $rubriekName = rubriekNrToRubriekName($_GET['rubriek']);
  }
  ?>
  <div class="pageContent">

    <div class="filter">
           <div class="binnen">
             <form class="form" action="veilingen.php">

                 <div class="input-group">

                     <div class="filterItemContainer">

                     <div class="filterItemBox">
                       <p class="filterHelpText">Zoek op naam</p>
                       <input type="text" class="form-control sugestion filterField" name="search_text" id="search_text"
                       placeholder="Zoeken" value="<?= textKeeper('search_text'); ?>" autocomplete="off">
                       <div class="above">
                           <div class="sugestion" id="auto">
                           </div>
                       </div>
                     </div>

                     <div class="filterItemBoxSmall">
                       <p class="filterHelpText">Min prijs</p>
                       <input type="number" class="form-control filterField" name="min_price" id="min_price" placeholder="0">
                     </div>
                     <div class="filterItemBoxSmall">
                       <p class="filterHelpText">Max prijs</p>
                       <input type="number" class="form-control filterField" name="max_price" id="max_price" placeholder="2000">
                     </div>
                     <div class="filterItemBox">
                       <p class="filterHelpText">Rubrieken</p>
                       <select class="form-control filterField" id="sel1" name="rubriek">
                         <option value="<?= textKeeper('rubriek')?textKeeper('rubriek'):'-1';?>">
                           <?=textKeeper('rubriek')?$rubriekName:'kies een rubriek';?></option>
                         <option value="-1">Alle rubrieken</option>
                         <?php
                           $Rubriekname = selectWhere('*,rubriek as parent','Rubriek','rubriek = -1 order by rubrieknaam ASC');
                           foreach ($Rubriekname as $result){
                         ?>
                       <option value="<?= $result['rubrieknummer'];?>">
                         <?=$result['rubrieknaam']?>
                       </option>
                       <?php
                                             $parent = $result['rubrieknummer'];
                                             $subRubriekResults = Aantal_items('v.title','R.rubrieknaam , R.rubrieknummer','Rubriek R','Voorwerp_in_Rubriek VR','R.rubrieknummer = VR.Rubriek_op_Laagste_Niveau','Voorwerp V','VR.voorwerpnummer = V.voorwerpnummer','R.rubrieknaam, R.rubrieknummer',$parent);
                                             foreach ($subRubriekResults as $subresult){
                                             ?>
                                             <option value="<?=$subresult['rubrieknummer'];?>">&nbsp;&nbsp;&nbsp;
                                               <?=$subresult['rubrieknaam'].' ('.$subresult['aantal'].')'?></option>
                                               <?php
                                               $parent1 = $subresult['rubrieknummer'];
                                               $subSubRubriekResults = Aantal_items('v.title','R.rubrieknaam , R.rubrieknummer','Rubriek R','Voorwerp_in_Rubriek VR','R.rubrieknummer = VR.Rubriek_op_Laagste_Niveau','Voorwerp V','VR.voorwerpnummer = V.voorwerpnummer','R.rubrieknaam, R.rubrieknummer',$parent1);
                                               foreach ($subSubRubriekResults as $suSubbresult){
                                               ?>
                                               <option  value="<?=$suSubbresult['rubrieknummer'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <?=$suSubbresult['rubrieknaam'].' ('.$suSubbresult['aantal'].')'?></option>
                           <?php
                         }}}
                           ?>
                     </select>
                   </div>
                   <div class="filterItemBox">
                     <p class="filterHelpText"> </p>
                     <div class="input-group">
                       <button type="submit" class="btn btn-success filterButton filterField" name="search">Zoeken</button>
                     </div>
                   </div>
                 </div>
                 </div>

           </form>
         </div>
         </div>
  <div class="gridContainer">

    <?php
      $autoincrement = 0;
      echo"
     <script>
     var countDownDate = [];
     </script>";
      foreach ($items as $item) {

        veilingItemBox($item['voorwerpnummer'],$autoincrement);
        $autoincrement++;

        $date =$item['looptijdeindeDag'].'T'.$item['looptijdeindetijdstip'];
        echo"
          <script>
          countDownDate.push(new Date('$date').getTime());
          </script>";

      }

    ?>


  </div>
  </div>
  <?php include 'recources/php/footer.php';
  include 'recources/js/countdownTimer.js';?>
