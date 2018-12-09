<?php
  $teller = 0;
  $pictures = selectWhereOrderBy("afbeelding","afbeelding_Voorwerp","voorwerpnummer = $itemNr","afbeelding");
  $active = 'active';
  $pPrefixDataBatch = "dt";
  $pPrefixLocal = "vi";
?>


<div id="pictureCarousel" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <?php foreach ($pictures as $picture):?>
      <li class="<?php echo $active?>" data-target="#pictureCarousel" data-slide-to="<?php echo $teller++;?>"></li>
    <?php
    $active = '';
   endforeach; ?>
 </ul>
  <div class="carousel-inner">
    <?php $active = 'active';
    foreach ($pictures as $picture): ?>
      <div class="carousel-item <?php echo $active?>">
        <?php $picturePrefix=mb_substr($picture['afbeelding'], 0, 2, 'utf-8');
          if($picturePrefix == $pPrefixDataBatch){
            $picPath = "http://iproject11.icasites.nl/pics/";
          }else if($picturePrefix == $pPrefixLocal){
            $picPath = "recources/images/veiling_items/$itemNr/";
          }
          ?>
        <img src="<?php echo $picPath.$picture['afbeelding']?>" alt="<?php echo $picture['afbeelding'] ?>" height="50%" width="100%" >
      </div>
    <?php
    $active = '';
    endforeach;
    ?>

      <a class="carousel-control-prev" href="#pictureCarousel" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#pictureCarousel" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
    </div>
