<?php

include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
include 'recources/php/functions/filterItems.php';
$autoincrement = 0;
echoHead("Mijn Veilingen | Eenmaal Andermaal");

  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
  }else{
    $username = "niet ingeloged";
  }

  $items = itemsFromUser($username);
?>

<body>

  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>
  <?php include 'recources/php/navbar.php';
  if(isset($_GET['rubriek'])){
    $rubriekName = rubriekNrToRubriekName($_GET['rubriek']);
  }
  ?>
  <form class='form-horizontal'action="veiling_maken.php" method="post" >
  <div class="pageContent">
    <h2>Mijn veilingen - <?php echo $username?></h2>
	<div class="form-group">
       <div class="col-sm-offset-2 col-sm-20">
         <button type="submit" class="btn buttonGreen" name="naarVeilingMaken">maak nieuwe veiling aan!</button>
       </div>
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
<?php include 'recources/php/footer.php'; ?>
