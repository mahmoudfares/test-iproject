<?php
include 'recources/php/head.php';
include 'recources/php/functions/toTop.php';
include 'recources/php/veilingBox.php';
include 'recources/php/functions/database/db_Settings.php';
require 'recources/php/functions/functie.php';

echoHead("Beheersomgeving | Eenmaal Andermaal");

$isBeheerder = isBeheerder($_SESSION["username"]);
if($isBeheerder == false){
  echo "Toegang geweigerd ";
}
if($isBeheerder){
?>

<body>
  <button onclick="topFunction()" id="topButton" title="Ga naar boven">Naar boven</button>
  <?php include 'recources/php/navbar.php' ?>
  <div class="itemPageContent">
    <div class="veilingItemPage">
      <h2>Beheersomgeving</h2>

      <div class="Admin">
      <div class="list-group">
          <a href="adminpage.php" class="list-group-item list-group-item-action">Gebruikers</a>
          <a href="adminpage.php?items" class="list-group-item list-group-item-action">Voorwerpen</a>
          <a href="adminpage.php?rubrieken" class="list-group-item list-group-item-action">Rubriek</a>
		  <a href="texttest.php" class="list-group-item list-group-item-action">Databatch</a>
		  <a href="kpi.php" class="list-group-item list-group-item-action">kpi's</a>
        </div>
        <?php
        if(!isset($_GET['items'])&&!isset($_GET['rubrieken'])){
        ?>
      <div class="container">
      <!--
      Gebruikers onderdeel
      !-->
        <h2>Gebruikers</h2>
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Gebruikersnaam</th>
              <th>voornaam en achternaam</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = selectWhere('*','Gebruiker','role <> 2');
            foreach ($results as $result):
            ?>
            <tr>
              <td><?= $result['Gebruikersnaam']?></td>
              <td><?= $result['voornaam'].' '.$result['achternaam'] ?></td>
              <td><?= $result['Mailbox']?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                 data-target="<?='#'.trim($result['Gebruikersnaam'])?>">
                    <i class="fa fa-trash" style="font-size:20px;color:white"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                 data-target="<?='#'.trim($result['Mailbox'])?>">
                    <i class="fa fa-envelope"></i>
                </button>
              </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <?php
      foreach ($results as $result):
      ?>
        <div class="modal fade" id="<?=trim($result['Gebruikersnaam'])?>">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Wilt u zeker de account<?=trim($result['Gebruikersnaam'])?>
                  blokkeren</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
                <a class="btn btn-danger" href="blok.php?request=Gebruiker&id=<?= $result['Gebruikersnaam']?>">Ja Zeker</a>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="<?=trim($result['Mailbox'])?>">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Email naar<?=trim($result['Mailbox'])?>
                  sturen:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
               <form class="form-horizontal" action="/action_page.php">
                <div class="form-group">
                    <label for="usr">Onderwerp:</label>
                    <input type="text" class="form-control" id="usr" >
              </div>
              <div class="form-group">
                <label for="comment">Inhoud:</label>
                <textarea class="form-control" rows="5" id="comment">Beste <?= $result['voornaam'].' '.$result['achternaam'] ?> </textarea>
              </div>
                   <input type="hidden" name="Mailbox" value="<?=$result['Mailbox']?>">
                   <button type="submit" class="btn btn-success">Submit</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach;
      }elseif(isset($_GET['items'])){
      ?>
      <div class="container">
        <h2>Veilingen</h2>
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>voorwerpnummer</th>
              <th>verkoper naam</th>
              <th>Startprijs</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = selectWhere('*','Voorwerp','velingsGesloten = 0');
            foreach ($results as $result):
            ?>
            <tr>
              <td><a class="idLink" href="Index.php?itemId=<?=$result['voorwerpnummer']?>"><?= $result['voorwerpnummer']?></a></td>
              <td><?= $result['verkoper']?></td>
              <td>€ <?= $result['Startprijs']?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                 data-target="<?='#'.trim($result['voorwerpnummer'])?>">
                  <i class="fa fa-close"></i>
                </button>
                <a class="btn btn-primary" href="Index.php?itemId=<?=$result['voorwerpnummer']?>">
                  <i class="fa fa-external-link"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <?php
      foreach ($results as $result):
      ?>
        <div class="modal fade" id="<?=trim($result['voorwerpnummer'])?>">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Wilt u zeker de veiling<?=trim($result['voorwerpnummer'])?>
                  blokkeren</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                  <div class="modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
                <a class="btn btn-danger" href="blok.php?id=<?= $result['voorwerpnummer']?>&request=Voorwerp">Ja Zeker</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach;
      ?>
      </div>
      <?php
      }elseif(isset($_GET['rubrieken'])){
      ?>

        <!-- Modal -->
        <div class="modal" id="rubriekToe" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Een Rubriek Toevoegen</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" action="insert.php" method="post">
                <div class="form-group">
                  <label for="sel1">Select list:</label>
                      <select class="form-control" id="sel1" name="rubriekParent">
                        <option value="-1">Root</option>
                          <?php
                          $Rubriekname = selectWhere('top (10) *,rubriek as parent','Rubriek','rubriek = -1 order by rubrieknummer ASC');
                          foreach ($Rubriekname as $result){
                          ?>
                          <option value="<?=$result['rubrieknummer']?>">
                            <?='('.$result['parent'].') '.$result['rubrieknaam'].' ('.$result['volgnr'].')'?>
                          </option>
                            <?php
                            $parent = $result['rubrieknummer'];
                            $subRubriekResults = selectWhere('top (10) *,rubriek as parent','Rubriek','rubriek ='.$parent);
                            foreach ($subRubriekResults as $subresult){
                            ?>
                            <option value="<?=$subresult['rubrieknummer']?>">&nbsp;&nbsp;&nbsp;
                              <?='('.$subresult['parent'] .') '.$subresult['rubrieknaam'].' ('.$subresult['volgnr'].')'?></option>
                              <?php
                              $parent1 = $subresult['rubrieknummer'];
                              $subSubRubriekResults = selectWhere('top (10) *,rubriek as parent','Rubriek','rubriek ='.$parent1);
                              foreach ($subSubRubriekResults as $suSubbresult){
                              ?>
                              <option  value="<?=$suSubbresult['rubrieknummer']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?='( '.$suSubbresult['parent'] .') '.$suSubbresult['rubrieknaam'].' ('.$suSubbresult['volgnr'].')'?></option>
                              <?php
                                  }}}
                              ?>
                </select>
              </div>
                  <div class="form-group">
                    <label for="usr">Rubriek naam:</label>
                    <input type="text" class="form-control" id="usr" name="rubriekName">
                  </div>
                  <div class="input-group">
                   <button type="submit" class="btn btn-default" name="insert">Toevoegen</button>
                   </div>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


      <div class="container">
        <h2 style="float: left; margin: 10px;">Rubrieken</h2>
        <button type="button" style="margin: 10px;" class="btn btn-info btn-lg" data-toggle="modal" data-target="#rubriekToe">voeg een rubriek toe <i class="fa fa-plus-square" style="font-size:24px"></i></button>
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Rubriek id</th>
              <th>Rubriek naam</th>
              <th>volgnr</th>
              <th>Rubriek Parent</th>
              <th>Aantal kinderen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $rubreiekn = selectWithJoin('A.rubrieknummer, A.rubrieknaam, B.rubrieknaam as parent, A.volgnr',
            'Rubriek A','Rubriek B','A.Rubriek = B.rubrieknummer','1=1 order by A.rubriek'
          );
            foreach ($rubreiekn as $result):
            ?>
            <tr>
              <td><?= $result['rubrieknummer']?></td>
              <td><?= $result['rubrieknaam']?></td>
              <td><?= $result['volgnr']?></td>
              <td><?= $result['parent']?></td>
              <td><?= selectAndCountWhere('rubriek','rubriek = '.$result['rubrieknummer'])?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                 data-target="<?='#'.trim($result['rubrieknummer'])?>">
                  <i class="fa fa-trash"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal"
                 data-target="<?='#'.trim($result['rubrieknaam'])?>">
                  <i class="fa fa-cog"></i>
				</button>
    
              </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <?php
      foreach ($rubreiekn as $result):
      ?>
        <div class="modal fade" id="<?=trim($result['rubrieknummer'])?>">
          <div class="modal-dialog modal-ml">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                <div class="alert alert-danger">
                 Wilt u zeker de rubriek <Strong><?=trim($result['rubrieknaam'])?>
                 </Strong>
                 vewijderen
                  </div>
                  </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                  <div class="modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
                <a class="btn btn-danger" href="delete.php?rubriek=<?= $result['rubrieknummer']?>">Ja Zeker</a>
              </div>
            </div>
          </div>
        </div>
		 <div class="modal fade" id="<?=trim($result['rubrieknaam'])?>">
          <div class="modal-dialog modal-ml">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                <div class="alert alert-danger">
                 Wilt u zeker de rubriek <Strong><?=trim($result['rubrieknaam'])?>
                 </Strong>
                 hernoemen
                  </div>
                  </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                  <div class="modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
                <a class="btn btn-danger" href="update.php?rubriek=<?= $result['rubrieknummer']?>">Ja Zeker</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach;
      ?>
      <?php }; ?>

    </div>
  </div>

<?php
}
 include 'recources/php/footer.php'; ?>
