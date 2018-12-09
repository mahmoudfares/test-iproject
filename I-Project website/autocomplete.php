<?php
  include 'recources/php/head.php';
  include 'recources/php/functions/functie.php';
  include 'recources/php/functions/filterItems.php';
  echoHead("wew");
  $searchTerm = $_POST['q'];
  $items = filterItemsByNameTop($searchTerm,5);
?>
<body>
<div class='autoCompleteBox'>
  <?php
    foreach($items as $item){
    echo '<a href="#" id="suggestion_items">'.$item['title']."</a><br>";
    }
    ?>
</div>
</body>
