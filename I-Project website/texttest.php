<?php
include 'recources/php/functions/functie.php';
include 'recources/php/head.php';
set_time_limit(0);

 echoHead("Testpagina | Eenmaal Andermaal");
if (isset($_POST['script'])) {
	$images = 0;
	$items  = 0;
	$users  = 0;
	
$script = $_POST['script'];
$script = str_replace ( "INSERT" , "|SPLIT| INSERT" ,$script, $count );
//str_replace vervangt het eerste item met de het tweede item uit het derde item, en geeft aan hoevaak ie gesplitst heeft in het 4e.
$values = explode("|SPLIT|", $script);
//explode splitst een string in een array van strings vanaf het eerste item

for ($i = 1; $i < $count +1; $i++) {

if(strstr ( $values[$i], 'INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving) VALUES') != false) {
	       $script = str_replace("INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving) VALUES (", "", $values[$i]);
	$items += 1;
	$tempcounterbase = 0;
    //check if its inserting a item or a user
	//$temp = str_replace("VALUES (","VALUES (", $script);
	$temp = str_replace ( "'" , "'" ,$script, $counter );
	$temp = explode("'", $script);
	for ($a = 0; $a < $counter; $a++) {
		if($a%2 == 1){	
		$temp[$a] = str_replace ( "," , "." ,$temp[$a], $tempcounter);	
		$tempcounterbase += $tempcounter;
		$tempcounter = 0;
		//echo $a;
		//echo $temp[$a];		
		}
	}
//als doorlopen: voeg samen
$scriptPart = implode("", $temp);
	//echo $scriptPart;
	
 
		//echo $scriptPart;
		//echo $scriptPart;
//gooit alle values onnodige informatie en INSERT weg
        $valuesPart = explode(",", $scriptPart);
//splitst de overgebleven waardes in losse arrays
        $valuesPart[0] = (float)$valuesPart[0];//int to float, want de int is te klein
        $valuesPart[7] = (int)$valuesPart[7];	
        $valuesPart[2] = (float)$valuesPart[2];
		//$valuesPart[1] = str_replace(" ", "", $valuesPart[1]); // haal de extra spaties weg
		//$valuesPart[6] = str_replace("'", "", $scriptPart); // haal de overgebleven ' weg
		$valuesPart[6] = str_replace("(", "", $valuesPart[6]); // haal de extra haakjes weg
		$valuesPart[6] = str_replace(" ", "", $valuesPart[6]); // haal de extra spaties weg
		if( $valuesPart[7] < 1){$valuesPart[7] = 1;} //geen negatieve getallen of 0 (CheckConstraint)	
		//echo $valuesPart[6];
		
		
//changing datatypes to int
       $insert = array($valuesPart[0], $valuesPart[1], $valuesPart[7], $valuesPart[4], $valuesPart[5], $valuesPart[6]);
	insert('Voorwerp',	'Voorwerpnummer,	title,		startprijs,		plaatsnaam,			land,		verkoper',
    '?,?,?,?,?,?',$insert);
	
	//$sql =  $GLOBALS['con']->query("insert Voorwerp(voorwerpnummer, title, startprijs, plaatsnaam, land, verkoper) VALUES(11086, '1x Diddl Briefpapier + Umschlag Set', 150, 'duitsland', 'duitsland','schwarzerengel258')");
	
	
	$insert = array($valuesPart[2], $valuesPart[0]);
	insert('Voorwerp_in_Rubriek','Rubriek_op_Laagste_Niveau, voorwerpnummer',
    '?,?',$insert);
//benodigde delen: id(0), titel(1), beschrijving(11), startprijs(7), bank, "" , locatie(4), land(5), "", "", "", "", "", verkoper(6), "", "", "", "", ""
    
}else if(strstr ($values[$i], 'INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES') != false) {
	$users += 1;
    //code users
    $scriptPart = str_replace("INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES", "",$values[$i]);//Haalt deze stuk weg en vervangt in 'leeg' van script
	$scriptPart = str_replace("'", "", $scriptPart); // haal de overgebleven ' weg
	$scriptPart = str_replace("(", "", $scriptPart); // haal de extra haakjes weg
    $valuesPart = explode(",",$scriptPart); //split een string in een array van strings op de komma's.
	$valuesPart[0] = str_replace(" ", "", $valuesPart[0]); // haal de extra spaties weg
    $insert = array($valuesPart[0],$valuesPart[1],$valuesPart[2],$valuesPart[3], 1);
   insert('Gebruiker', 'Gebruikersnaam ,postcode,plaatsnaam,landnaam, Verkoper','?,?,?,?,?',$insert);
     insert('Verkoper', 'Gebruiker','?',$valuesPart);
		
}else if(strstr ($values[$i], 'INSERT Illustraties (ItemID,IllustratieFile) VALUES') != false) {
	$images += 1;
    //code users
    $scriptPart = str_replace("INSERT Illustraties (ItemID,IllustratieFile) VALUES (", "",$values[$i]);//Haalt deze stuk weg en vervangt in 'leeg' van script
	$scriptPart = str_replace("'", "", $scriptPart);
	$scriptPart = str_replace(" ", "", $scriptPart);
	$scriptPart = str_replace(")", "", $scriptPart);
    $valuesPart = explode(",",$scriptPart); //split een string in een array van strings op de komma's.
	$valuesPart[0] = (float)$valuesPart[0];
    $insert = array($valuesPart[0],$valuesPart[1]);
	//echo $valuesPart[1];
	
   insert('afbeelding_Voorwerp', 'voorwerpnummer, afbeelding','?,?',$insert);
}
}
}

 ?>
 
<body>
 <?php include 'recources/php/navbar.php' ?>
 <div class="pageContent">
<div class="veilingItemPage">
<div class="registeren" style="color:black;">
  <h2>Batch insert</h2>

<form class='form-horizontal'action="" method="post" >
    <p>voer aub het oude insertscript in</p>
    <div class="alert alert-danger">
         <p>Pas op! alle html/css/php word automatisch uit de beschijving gefilterd!</p><br>
		 <p>Voeg maximaal +- 350 items tegelijk toe!</p>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="script">Vul script in<p class="required">* verplicht</p></label>
		<label class="control-label col-sm-2" for="script"><?php if (isset($_POST['script'])) {
			echo 'Er zijn '; echo $items; echo ' items toegevoegd'; echo '<br>';
			echo 'Er zijn '; echo $users; echo ' users toegevoegd'; echo '<br>';
			echo 'Er zijn '; echo $images; echo ' afbeeldingen toegevoegd'; echo '<br>';		} ?><p class="required"></p></label>
        <div class="col-sm-20">
		  <textarea name="script" style="width:100%;height:150px;"></textarea>
        </div>
		<div class="col-sm-offset-2 col-sm-20">
         <button type="submit" class="btn buttonGreen" name="send">Voer script uit!</button>
       </div>
    </div>
    
     </div>
</form>
</div>
</div>
<?php include 'recources/php/footer.php'; ?>
