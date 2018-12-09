<?php
require_once'recources/php/functions/functie.php';
if(isset($_GET["search"])||isset($_GET["ordering"])){
  $search = '%'.htmlspecialchars(textkeeper('search_text')).'%';
  $rubriek = htmlspecialchars(textkeeper("rubriek"));
  $where = 'vr.Rubriek_op_Laagste_Niveau =';
  $end = strpos($rubriek,'/');
  $rubrikename = substr($rubriek, $end+1 ,strlen($rubriek));
  $rubriek = substr($rubriek,0,$end);
  $ordering = textkeeper('ordering')?textkeeper('ordering'):'Startprijs';
  if($rubriek == -1){
    $rubrikename = 'alle rubrieken';
    $where = "-1 =";
  }
  $values = array('search' => $search,'rubriek'=>$rubriek);
  $items = selectWithJoin('*','Voorwerp v','Voorwerp_in_Rubriek vr ','v.voorwerpnummer =
  vr.voorwerpnummer join Gebruiker G on G.Gebruikersnaam = v.verkoper',
  "title like :search and ".$where." :rubriek order by ".$ordering,$values);
}else{
  $items = selectWithJoin('*','Voorwerp v','Gebruiker G ','G.Gebruikersnaam = v.verkoper');
}
if(isset($_POST['search'])){
$response = '<ul id="sugestion-list"><li>no data found</ul></li>';
$search = '%'.$_POST['q'].'%';
 $autoCompleet = selectWhere('DISTINCT title','Voorwerp',"title like '%$search%'");
 $response = '<ul>';
 foreach ($autoCompleet as $result) {
   $response .= "<a href='#'><li id = 'suggestion_items'>".$result['title']."</li></a>";
 }
 $response .= '</ul>';
  exit($response);
}
?>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    <div class="onder-header">
      <?php
    if(!isset($_SESSION['user'])):

     ?>
        <div class="flex">
          <?php $itemCount = selectAndCountJoin('Voorwerp v','Gebruiker G ','G.Gebruikersnaam = v.verkoper');
                $usersCount = selectAndCountWhere('Gebruiker');
          ?>
            <div class="flex-sons"><strong><?=$usersCount?></strong>Gebruikers</div>
            <div class="flex-sons"><strong><?= $itemCount ?></strong>Veilingen per dag</div>
            <div class="flex-sons"><strong>24/7</strong>Bereikbaar</div>
        </div>
        <div class="peroneal">
            <h4>Wordt nu een lid om optimaal gebruik te maken van de website</h4>
            <a href="log-in.php" class="btn btn-success" role="button">Inloggen</a>
            <a href="registreren.php" class="btn btn-success" role="button">Registreren</a>
        </div>
        <?php
        endif;
       ?>
    </div>
      <div class="filter">
        <div class="binnen">
          <form class="form" action="index.php">
              <div class="input-group">
                  <input type="text" class="form-control sugestion" name="search_text" id="search"
                    placeholder="Zoeken" value="<?= textKeeper('search_text'); ?>" autocomplete="off">
                  <select class="form-control" id="sel1" name="rubriek">
                    <option value="<?= textKeeper('rubriek')?textKeeper('rubriek'):'-1/root';?>">
                      <?=textKeeper('rubriek')?$rubrikename:'kiest u een rubriek';?></option>
                    <option value="-1/root">Alle rubrieken</option>
                      <?php
                        $Rubriekname = selectWhere('*,rubriek as parent','Rubriek','rubriek = -1 order by rubrieknummer ASC');
                        foreach ($Rubriekname as $result){
                      ?>
                    <option value="<?= $result['rubrieknummer'].'/'.$result['rubrieknaam'];?>">
                      <?='('.$result['parent'].') '.$result['rubrieknaam'].' ('.$result['volgnr'].')'?>
                    </option>
                      <?php
                      $parent = $result['rubrieknummer'];
                      $subRubriekResults = selectWhere('* ,rubriek as parent','Rubriek','rubriek ='.$parent);
                      foreach ($subRubriekResults as $subresult){
                      ?>
                      <option value="<?=$subresult['rubrieknummer'].'/'.$subresult['rubrieknaam'];?>">&nbsp;&nbsp;&nbsp;
                        <?='('.$subresult['parent'] .') '.$subresult['rubrieknaam'].' ('.$subresult['volgnr'].')'?></option>
                        <?php
                        $parent1 = $subresult['rubrieknummer'];
                        $subSubRubriekResults = selectWhere('* ,rubriek as parent','Rubriek','rubriek ='.$parent1);
                        foreach ($subSubRubriekResults as $suSubbresult){
                        ?>
                        <option  value="<?=$suSubbresult['rubrieknummer'].'/'.$suSubbresult['rubrieknaam'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <?='( '.$suSubbresult['parent'] .') '.$suSubbresult['rubrieknaam'].' ('.$suSubbresult['volgnr'].')'?></option>
                        <?php
                            }}}
                        ?>
                  </select>
              </div>
            <div class="above">
                <div class="sugestion" id="auto">
                </div>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="postal" placeholder="Uw postcode">
                <select class="selectpicker" >
                  <option>Alle Afstanden</option>
                  <option>> 3KM</option>
                  <option>> 10KM</option>
                  <option>> 15KM</option>
                </select>
                <select class="form-control" name="ordering" onchange="this.form.submit()">
                  <option value="" >....</option>
                  <option value="startprijs desc" >Prijs omlaag</option>
                  <option value="startprijs ASC">prijs omhoog</option>
                  <option value="looptijdbegindag desc,looptijdbeginTijdstip desc">nieuwste  </option>
                  <option value="looptijdbegindag ASC,looptijdbeginTijdstip asc">oudste</option>
                </select>
              <button type="submit" class="btn btn-success" name="search">Zoeken</button>
            </div>
            <label>505 resultaten..</label>
            <a href="Admin.php" class="btn btn-success" >Admin</a>
        </form>
      </div>
      </div>
    <div class="container">
      <?php include'recources/php/breadcrumb.php'; ?>
    </div>
    <div class="items">
      <?php
      echo"
      <script>
      var countDownDate = [];
      </script>";
      $autoincrement = 0;
      foreach ($items as $item): ?>
        <div class="item">
          <a href="item.php?itemId=<?=$item['voorwerpnummer']?>">
            <img src="media/<?=trim($item['title'])?>.JPG" height="300" style="border-bottom: 2px solid gray">
            <div class="details">
            <h6><?= $item['title'] ?></h6>
            <div class="text">
            <p>&euro; <?= $item['Startprijs'] ?></p>
            <p id="<?='demo'.$autoincrement++;?>"></p>
            </div>
            <p>Verkopr: <?= $item['voornaam'] .' '. $item['achternaam']?></p>
            </div>
            </a>
        </div>
      <?php
      $item['looptijdbegindag'];
      $date ='11 05, 2018'.' '.$item['looptijdeindetijdstip'];
      echo"
      <script>
      countDownDate.push(new Date('$date').getTime());
      </script>";
      endforeach ?>
    </div>
    <!-- Display the countdown timer in an element -->
 <script>
 var teller = 0;
 var x = [];
     x[teller] = setInterval(function() {
     for(i = 0;i<countDownDate.length;i++) {
       teller = i;
     var now = new Date().getTime();
     var distance = countDownDate[i] - now;
     console.log(i);
     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
     var seconds = Math.floor((distance % (1000 * 60)) / 1000);
     document.getElementById("demo"+i).innerHTML = "Nog: "+ days + "d " + hours + "h "
     + minutes + "m " + seconds + "s ";
     if (distance < 0) {
       clearInterval(x[i]);
       document.getElementById("demo"+i).innerHTML = "EXPIRED";
     }
    }
   },1000);
 </script>
