<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/functions/functie.php';
echoHead("KPI | Eenmaal Andermaal");
?>

<body>

  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>

  <?php include 'recources/php/navbar.php'; 
   $itemCount = selectAndCountJoin('Voorwerp v','Gebruiker G ','G.Gebruikersnaam = v.verkoper');
   $usersCount = selectAndCountWhere('Gebruiker');
   $Verkoperscount = selectAndCountWhere('Gebruiker','verkoper = 1');
          ?>
		  
  <div class="onder-header">
        <div class="flex">
            <div class="flex-sons"><strong><?=$usersCount?>&nbsp </strong>Aantal gebruikers</div>
            <div class="flex-sons"><strong><?= $itemCount?>&nbsp </strong>Aantal veilingen</div>
			<div class="flex-sons"><strong><?= $Verkoperscount?>&nbsp </strong>Aantal verkopers</div>
		</div>
	</div>
  <iframe width="800" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiMjMyNzI4MmUtN2IxOS00ZjNiLTlmMzQtMGFiNmUzN2Q3ZmNlIiwidCI6ImI2N2RjOTdiLTNlZTAtNDAyZi1iNjJkLWFmY2QwMTBlMzA1YiIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
  
  </body>
  