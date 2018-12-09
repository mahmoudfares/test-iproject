<?php
include 'recources/php/functions/functie.php';
include 'recources/php/head.php';
$validation = array();
if(isset($_POST['registreren'])){
  $validation = validation($_POST,array(
    'voornaam'=>array(
      'verplicht'=>true,
      'letters'=>true,
      'max'=>25
    ),
    'achternaam'=>array(
      'verplicht'=>true,
      'letters'=>true,
      'max'=>25
    ),
    'landnaam'=>array(
      'verplicht'=>true,
      'letters'=>true,
      'max'=>20
    ),
    'plaatsnaam'=>array(
      'verplicht'=>true,
      'letters'=>true,
    ),
    'adresregel1'=>array(
      'verplicht'=>true,
      'max'=>25
    ),
    'adresregel2'=>array(
      'max'=>25
    ),
    'postcode'=>array(
      'max'=>6
    ),
    'GeboorteDag'=>array(
      'verplicht'=>true,
      'max'=>10
    ),
    'Telefoonnummer'=>array(
      'verplicht'=>true,
      'max'=>11,
      'nummers'=>true
    ),
    'Gebruikersnaam'=>array(
      'verplicht'=>true,
      'max'=>100,
    ),
    'Mailbox'=>array(
      'verplicht'=>true,
      'max'=>50,
      'email'=>true
    ),
    'wachtwoord'=>array(
      'verplicht'=>true,
      'max'=>50,
    ),
    'antwoordtekst'=>array(
      'verplicht'=>true,
      'max'=>30
    )
  ));
  if ($unique = selectAndCountWhere('Gebruiker','Gebruikersnaam=? or Mailbox = ?',
    array($_POST['Gebruikersnaam'],$_POST['Mailbox']))){
    $validation[] = 'Gebruikersnaam of email al in gebruik';
  }
  if(!$validation){
    $wachtwoordhash = md5($_POST['wachtwoord']);
    $values = array($_POST['Gebruikersnaam'],$_POST['voornaam'],$_POST['achternaam'],$_POST['adresregel1'],
    $_POST['adresregel2'],$_POST['postcode'],$_POST['plaatsnaam'],$_POST['landnaam'],$_POST['antwoordtekst'],
    $_POST['GeboorteDag'],$_POST['Mailbox'],$wachtwoordhash,$_POST['vraag']);
    insert('Gebruiker','Gebruikersnaam,voornaam,achternaam,adresregel1,adresregel2,
    postcode,plaatsnaam,landnaam,antwoordtekst,GeboorteDag,Mailbox,wachtwoord,vraag',
    '?,?,?,?,?,?,?,?,?,?,?,?,?',$values);
	$valuesTel = array($_POST['Gebruikersnaam'],$_POST['Telefoonnummer']);
	insert('Gebruikerstelefoon','Gebruikersnaam,Telefoon',
    '?,?',$valuesTel);

    $wait = 5;
    $welcome = "<h3>Welcome ".$_POST['Gebruikersnaam']." U wordt over $wait seconde naar de home pagina gestuud</h3>";
    header("Refresh: $wait; URL=home.php");
  }
}


 echoHead("Registreren | Eenmaal Andermaal");

 ?>

 <body>
 <?php include 'recources/php/navbar.php' ?>
 <div class="pageContent">
<div class="veilingItemPage">
<div class="registeren" style="color:black;">
  <h2>Registeren</h2>

<form class='form-horizontal'action="" method="post" >
    <p>voer aub het formulier in om te registeren</p>
    <?php foreach ($validation as $validate ):?>
    <div class="alert alert-danger">
         <?php echo $validate ?>
    </div>
    <?php endforeach; ?>
    <div class="form-group">
        <label class="control-label col-sm-2" for="Gebruikersnaam">Gebruikersnaam<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="Gebruikersnaam" value="" name="Gebruikersnaam" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="voornaam">Voornaam<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="voornaam" value="" name="voornaam" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="achternaam">Achternaam<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="achternaam" value="" name="achternaam" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="Mailbox">Email<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="email" class="form-control" id="Mailbox" value="" name="Mailbox" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="wachtwoord">Wachtwoord<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="password" class="form-control" id="wachtwoord" value="" name="wachtwoord" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="landnaam">Land<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="landnaam" value="Nederland" name="landnaam" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="plaatsnaam">Plaatsnaam<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="plaatsnaam" value="" name="plaatsnaam" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="adresregel1">Adresregel1<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="adresregel1" value="" name="adresregel1" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="adresregel2">Adresregel2</label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="adresregel2" value="" name="adresregel2">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="postcode">Postcode<p class="required">* verplicht</p></label>
        <div class="col-sm-20">
          <input type="text" class="form-control" id="postcode" value="" name="postcode" required>
        </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="GeboorteDag">GeboorteDag<p class="required">* verplicht</p></label>
      <div class="col-sm-20">
        <input type="date" name="GeboorteDag" class="form-control" value="<?= $information[0]['GeboorteDag']?>" name="GeboorteDag" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="Telefoonnummer">Telefoonnummer<p class="required">* verplicht</p></label>
      <div class="col-sm-20">
        <input type="text" class="form-control" id="Telefoonnummer" name="Telefoonnummer" required>
      </div>
    </div>
    <div class="form-inline">
       <p>Uw geheime vraag:<p class="required">* verplicht</p> &nbsp;&nbsp; </p>
        <div class="col-sm-offset-2 col-sm-20">
          <select name="vraag" id="vraag" class="form-control">
            <?php
            $vragen = selectWhere( '*','vraag');
            foreach($vragen as $vraag){
              ?>
              <option value="<?php echo $vraag['vraagnummer']?>"><?php echo $vraag['tekst_vraag']?></option>
            <?php };?>
          </select> &nbsp;&nbsp;
          </div>
          <input type="text" class="form-control" id="antwoordtekst" placeholder="Antwoord" value="" name="antwoordtekst" required>
    </div>
    <div class="form-group">
       <div class="col-sm-offset-2 col-sm-20">
         <button type="submit" class="btn buttonGreen" name="registreren">Registreren</button>
       </div>
     </div>
</form>
</div>
</div>
<?php include 'recources/php/footer.php'; ?>
