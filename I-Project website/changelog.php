<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/functions/functie.php';
echoHead("Changelog | Eenmaal Andermaal");
?>

<body>

  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>

  <?php include 'recources/php/navbar.php'; ?>

<div class="pageContent">
<table style="width:100%">
  <tr>
    <td><STRONG>Naam van verandering</STRONG></td>
    <td><STRONG>Beschrijving</STRONG></td>
    <td><STRONG>Versie</STRONG></td>
    <td><STRONG>Auteur</STRONG></td>
    <td><STRONG>datum/tijd</STRONG></td>
  </tr>

  <tr>
    <td>Gesloten veilingen niet weergeven, databatch import script, veilingen toevoegen, fotos op itempagina</td>
    <td></td>
    <td>v0.5</td>
    <td>Tim en Dennis</td>
    <td>07/06/2018 18:00</td>
  </tr>

  <tr>
    <td>Aantal items per rubriek, databatch thumbnail, sorteren veilingen op tijd</td>
    <td></td>
    <td>v0.4</td>
    <td>Dennis en Ronald</td>
    <td>04/06/2018 16:00</td>
  </tr>

  <tr>
    <td>Countdown klok safari(ios) fix</td>
    <td>Probleem waarbij safari op ios de resterende veiling tijd weergegeven werdt als "NaN NaN NaN NaN"</td>
    <td>v0.3b</td>
    <td>Dennis</td>
    <td>04/06/2018 12:40</td>
  </tr>

  <tr>
    <td>Responsive navbar</td>
    <td>De navbar is nu responsive, dit zorgt er voor dat deze nu ook op mobiel goed te gebruiken is.</td>
    <td>v0.3</td>
    <td>Dennis</td>
    <td>04/06/2018 12:00</td>
  </tr>

  <tr>
    <td>Op meerdere keywords zoeken bij <a href="veilingen.php">veilingen</a></td>
    <td>Het is nu mogelijk om op verschillende keywords te zoeken op de veilingen pagina, hierdoor kan je als gebruiker makkelijker voorwerpen vinden.</td>
    <td>v0.2</td>
    <td>Mahmoud</td>
    <td>04/06/2018 11:00</td>
  </tr>

  <tr>
    <td><a href=http://iproject11.icasites.nl>Nieuw website ontwerp</a></td>
    <td>De website heeft nu het moderne ontwerp en is beter upgebouwd zodat er makkelijker veranderingen gemaakt kunnen worden.</td>
    <td>v0.1</td>
	  <td>Ronald, Tim, Cemal, Mahmoud en Dennis</td>
    <td>23/05/2018 9:30</td>
   </tr>


</table>
</div>
<?php include 'recources/php/footer.php'; ?>
