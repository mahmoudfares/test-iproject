<?php
include 'recources/php/functions/functie.php';
include 'recources/php/head.php';
$validation = array();
if(isset($_POST['veilingMaken'])){
	//echo 'testing now';
	//echo $_POST['titel'];
	//echo $_POST['beschrijving'];
	//echo $_POST['days'];
	//echo $_POST['startprijs'];
	$insert = array($_POST['ID'],$_POST['titel'], $_POST['beschrijving'], $_POST['days'] * 24, $_POST['startprijs'],'Arnhem','Nederland', $_SESSION['username']);
	insert('Voorwerp', 'voorwerpnummer, title ,beschrijving , looptijd ,startprijs,plaatsnaam, land, verkoper','?,?,?,?,?, ?,?,?',$insert);
	$insert_rubriek = array($_POST['rubriek'], $_POST['ID']);
	insert('Voorwerp_in_Rubriek', 'Rubriek_op_Laagste_Niveau,voorwerpnummer', '?,?', $insert_rubriek);
	
}
 echoHead("Registreren | Eenmaal Andermaal");

 ?>

 <body>
 <?php include 'recources/php/navbar.php' ?>
 <div class="pageContent">
<div class="veilingItemPage">
<div class="registeren" style="color:black;">
  <h2>nieuwe veiling maken</h2>
  <?php
  if(isset($_POST['veilingMaken'])){
	echo '<div class="alert alert-succes">
<p>U heeft een nieuwe veiling aangemaakt!</p><br>
</div>';
  }
?>
<form class='form-horizontal'action="" method="post" >
    <p>voer aub het formulier in om een nieuwe veiling te maken</p>
    <div class="form-group">
        <label class="control-label col-sm-2" for="titel">titel<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="titel" value="" name="titel" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="beschrijving">beschrijving<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="beschrijving" value="" name="beschrijving" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="length">veiling open voor:</label>
        <div class="col-sm-20">
  <select name="days">
    <option value="1">1 dag</option>
    <option value="3">3 dagen</option>
    <option value="5">5 dagen</option>
    <option value="7">7 dagen</option>
  </select>
  <br>
			</div>


        </div>
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
	  <div class="form-group">
        <label class="control-label col-sm-2" for="ID">item ID<p class="required">* verplicht, moet uniek zijn</p></label>
        <div class="col-sm-20">
          <input type="number" name="ID" min="100" max="100000000000">
        </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="startprijs">startprijs<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="number" name="startprijs" min="0" max="90000">
        </div>
    </div>
    <div class="form-group">
       <div class="col-sm-offset-2 col-sm-20">
         <button type="submit" class="btn buttonGreen" name="veilingMaken">maak nieuwe veiling aan!</button>
       </div>
     </div>
</form>
</div>
</div>
<?php include 'recources/php/footer.php'; ?>
