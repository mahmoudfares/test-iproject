<?php
require_once'functie.php';
function filterItems($getRubriek, $getSearch,$min_price = 0,$max_price = 99999){
  $rubriekNr = '';
  $whereInfo = '';
  $getRubriek = (int)$getRubriek;
  echo $min_price;
  //checkt of er naar een bepaalde rubriek of search_text word gezocht.
  if((isset($getRubriek) && $getRubriek > 0) || isset($getSearch) || isset($min_price) || isset($max_price)){
    $whereInfo .= 'where ';


    if(isset($getRubriek) && $getRubriek >= 0){
      if(is_numeric($getRubriek)){
        $rubriekNr = $getRubriek;
        if($getRubriek > 0){
          $filterRubriek = "VIR.Rubriek_op_Laagste_Niveau = $rubriekNr";
          $whereInfo .= $filterRubriek;
          $whereInfo .= " AND ";
        }

        // if(isset($getSearch) || isset($min_price) || isset($max_price)){
        //   $whereInfo .= " AND ";
        // }
      }
      else{
        echo '<p style="background-color: red; color: white">Dit is geen rubrieknummer '.$getRubriek.'</p>';
        $whereInfo = '';
      }
    }

    if(isset($getSearch)){
      $searchInfo = htmlspecialchars($getSearch);
      $search = '\''.'%'.$searchInfo.'%'.'\'';
      $filterSearch = 'V.title like '.$search;
      $whereInfo .= $filterSearch;
      $whereInfo .= " AND ";
      // if(isset($min_price) || isset($max_price)){
      //   $whereInfo .= " AND ";
      // }
    }
      if(isset($min_price) && isset($max_price)) {
          $whereInfo .= "V.verkopprijs BETWEEN ".$min_price." AND ".$max_price;
      }
  }
  $sql=$GLOBALS['con']->query("select V.voorwerpnummer from Voorwerp V join Voorwerp_in_Rubriek VIR on V.voorwerpnummer = VIR.voorwerpnummer $whereInfo");
  $items=$sql->fetchAll(PDO::FETCH_ASSOC);
  return $items;
  }

  function filterItems2($rubriek, $searchText, $minPrice, $maxPrice){

    if(empty($minPrice)){
      $minPrice = 0;
    }
    if(empty($maxPrice)){
      $maxPrice = 999999999;
    }
    if(!isset($rubriek) || !is_numeric($rubriek) || $rubriek <= 0){
      $rubriek = "VIR.Rubriek_op_Laagste_Niveau";
    }
    if(empty($searchText)){
      $searchText = "";
    }
    $sql=$GLOBALS['con']->query(
      "select V.voorwerpnummer
       from Voorwerp  join Voorwerp_in_Rubriek VIR on V.voorwerpnummer = VIR.voorwerpnummer
       where VIR.Rubriek_op_Laagste_Niveau = $rubriek AND V.title like '%$searchText%' AND (V.verkopprijs BETWEEN $minPrice AND $maxPrice)");
    $items=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }


  function filterItemsByName($name){
    $sql=$GLOBALS['con']->query("select title from Voorwerp where title like '%$name%' group by title");
    $items=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }

  function filterItemsByNameTop($name, $top){
    $sql=$GLOBALS['con']->query("select top($top) title from Voorwerp where title like '%$name%' group by title");
    $items=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }

  function rubriekNrToRubriekName($rubriekNr){
    $rubriekName = 'Alle rubrieken';
    if($rubriekNr > 0){
      $sql=$GLOBALS['con']->query("select rubrieknaam from Rubriek where rubrieknummer = $rubriekNr");
      $rubrieken=$sql->fetchAll(PDO::FETCH_ASSOC);
      foreach ($rubrieken as $rubriek) {
        $rubriekName = $rubriek['rubrieknaam'];
      }
    }



    return $rubriekName;
  }

  function itemsFromUser($user){
    $sql=$GLOBALS['con']->query("select V.voorwerpnummer, v.looptijdeindeDag, v.looptijdeindetijdstip from Voorwerp V where verkoper = '$user'");
    $items=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }
?>
