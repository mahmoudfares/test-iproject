<?php
require_once'recources/php/functions/functie.php';
$breadcrumbs = array(array(
  'link' => 'home.php',
  'title'=> 'Home',
));
 ?>

 <?php function showBreadcrumb($breadcrumbs){ ?>
  <ol class="breadcrumb" style="width: 100%; height: 50px; margin-bottom:0px;">
<?php foreach ($breadcrumbs as $breadcrumb): ?>
    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['link'] ?>"><?php echo $breadcrumb['title'] ?></a></li>
<?php endforeach; ?>
  </ol>
<?php } ?>
