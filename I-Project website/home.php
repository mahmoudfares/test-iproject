<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
echoHead("Home | Eenmaal Andermaal");
?>

<body>
  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>
  <?php include 'recources/php/navbar.php' ?>
  <div class="pageContent">

  <?php
  if (isset($_SESSION["username"]) != ""){
    $welkomBericht = '<h2>Welkom '.$_SESSION["username"].'</h2>';
  }else {
    $welkomBericht = '<h2>Welkom op Eenmaal Andermaal</h2>';
  }
  echo $welkomBericht;
  ?>
  <!-- <h2>Welkom op Eenmaal Andermaal</h2> -->
  <!--  <p>Tekst </p> -->
<h4>Wordt nu een lid om optimaal gebruik te maken van de website</h4>

  <h2>Populaire veilingen</h2>
  <div class="gridContainer">
    <?php
    $autoincrement = 0;
    echo"
   <script>
   var countDownDate = [];
   </script>";
     $sql=$GLOBALS['con']->query("select top (4) voorwerpnummer, count(Bodbedrag) as 'biedingen', V.looptijdeindeDag, V.looptijdeindetijdstip from Voorwerp V left join bod b on v.voorwerpnummer = b.voorwerp where V.looptijdeindeDag > CONVERT (date, SYSDATETIME()) group by v.voorwerpnummer, v.looptijdeindeDag, v.looptijdeindetijdstip order by biedingen desc");
     $items=$sql->fetchAll(PDO::FETCH_ASSOC);
      foreach ($items as $item) {
        veilingItemBox($item['voorwerpnummer'],$autoincrement);
        $autoincrement++;

        $date =$item['looptijdeindeDag'].' '.$item['looptijdeindetijdstip'];
        echo"
          <script>
          countDownDate.push(new Date('$date').getTime());
          </script>";
      }
    ?>
  </div>
  <h2>Duurste veilingen</h2>
  <div class="gridContainer">
    <?php
     $sql=$GLOBALS['con']->query("select top (4) voorwerpnummer, looptijdeindeDag, looptijdeindetijdstip from Voorwerp where looptijdeindeDag > CONVERT (date, SYSDATETIME())group by voorwerpnummer, looptijdeindeDag, looptijdeindetijdstip, verkopprijs, startprijs order by verkopprijs desc, Startprijs desc");
     $items=$sql->fetchAll(PDO::FETCH_ASSOC);
      foreach ($items as $item) {
        veilingItemBox($item['voorwerpnummer'],$autoincrement);
        $autoincrement++;

        $date =$item['looptijdeindeDag'].' '.$item['looptijdeindetijdstip'];
        echo"
          <script>
          countDownDate.push(new Date('$date').getTime());
          </script>";
      }
    ?>
  </div>
  <h2>Nieuwste veilingen</h2>
  <div class="gridContainer">
    <?php
     $sql=$GLOBALS['con']->query("select top (4) voorwerpnummer, looptijdeindeDag, looptijdeindetijdstip from Voorwerp where looptijdeindeDag > CONVERT (date, SYSDATETIME())group by voorwerpnummer, looptijdeindeDag, looptijdeindetijdstip, looptijdBegintijdstip, looptijdBeginDag order by looptijdBeginDag desc, looptijdBegintijdstip desc");
     $items=$sql->fetchAll(PDO::FETCH_ASSOC);
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
<?php include 'recources/php/footer.php'; ?>
