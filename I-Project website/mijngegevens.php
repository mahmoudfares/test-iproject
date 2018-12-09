<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/functie.php';
include 'recources/php/functions/database/db_Settings.php';
echoHead("Home | Eenmaal Andermaal");

//require'recources/php/functions/functie.php';
include_once'recources/php/head.php';
if(isset($_GET['id'])&&$_GET['id']==$_SESSION['username']):
$information = selectWhere('*','Gebruiker', 'Gebruikersnaam = ?', [$_SESSION['username']]);
$telephone = selectWhere('*','Gebruikerstelefoon', 'Gebruikersnaam = ?', [$_SESSION['username']]);
$validation = array();
if(isset($_POST['change'])):
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
    'Telefoon'=>array(
      'verplicht'=>true,
      'max'=>11,
      'nummers'=>true
    )
  ));
  if(!$validation):
    $values = array($_POST['voornaam'],$_POST['achternaam'],$_POST['landnaam'],
    $_POST['plaatsnaam'],$_POST['adresregel1'],$_POST['adresregel2'],$_POST['GeboorteDag'],$_POST['postcode'],$_SESSION['username']);
    $sql =  $GLOBALS['con']->prepare("update Gebruiker set
    voornaam = ?,
    achternaam = ?,
    landnaam = ?,
    plaatsnaam = ?,
    adresregel1 = ?,
    adresregel2 = ?,
    GeboorteDag = ?,
    postcode = ?,
	verkoper = 1
    where Gebruikersnaam = ?");
    $sql->execute($values);
    $sql =  $GLOBALS['con']->prepare("update Gebruikerstelefoon set Telefoon = ? where Gebruikersnaam = ?");
    $sql->execute(array($_POST['Telefoon'],$_SESSION['username']));
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit();
  endif;
endif;
?>

<?php include 'recources/php/navbar.php' ?>
<div class="pageContent">
<div class="veilingItemPage">
<div class="profile">
<h2 style="text-align:center;">Mijn gegevens:</h2>
<?php foreach ($validation as $validate ):?>
<div class="alert alert-danger">
     <?php echo $validate ?>
</div>
<?php endforeach; ?>
<form class="form-horizontal" action="" method="post">
  <div class="form-group">
    <label class="control-label col-sm-2" for="voornaam">Voornaam</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="voornaam" value="<?= $information[0]['voornaam']?>" name="voornaam" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="achternaam">Achternaam</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="achternaam" value="<?= $information[0]['achternaam']?>" name="achternaam" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="Telefoon">Telefoon</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="Telefoon"
      value="<?php echo trim($telephone[0]['Telefoon']);?>"
        name="Telefoon">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="landnaam">landnaam</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="landnaam" value="<?= $information[0]['landnaam']?>" name="landnaam" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="plaatsnaam">plaatsnaam</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="plaatsnaam" value="<?= $information[0]['plaatsnaam']?>" name="plaatsnaam" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="postcode">postcode</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="postcode" value="<?= $information[0]['postcode']?>" name="postcode" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="adresregel1">adresregel1</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="adresregel1" value="<?= $information[0]['adresregel1']?>" name="adresregel1" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="adresregel2">adresregel2</label>
    <div class="col-sm-20">
      <input type="text" class="form-control" id="adresregel2" value="<?= $information[0]['adresregel2']?>" name="adresregel2">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="GeboorteDag">GeboorteDag</label>
    <div class="col-sm-20">
      <input type="date" name="GeboorteDag" class="form-control" value="<?= $information[0]['GeboorteDag']?>" name="GeboorteDag" required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="verkoper">verkoper</label>
    <div class="col-sm-20">
      <input type="checkbox" name="verkoper" class="form-control" value="<?= $information[0]['verkoper']?>" name="verkoper" required>
    </div>
  </div>
  <div class="form-group">
     <div class="col-sm-offset-2 col-sm-20">
       <button type="submit" class="btn buttonGreen" name="change">Aanpassen</button>
     </div>
   </div>
</form>
</div>
</div>
</div>

<?php
else:
  header('location:index.php');
  exit();
  endif;
  include_once'recources/php/footer.php';
 ?>
