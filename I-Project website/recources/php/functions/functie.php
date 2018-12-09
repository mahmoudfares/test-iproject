<?php
require 'database/db_Settings.php';

//retunert de data van database
function selectWithJoin($gewenstecolumen = '*',$eersteTabel,$tweedeTable,$on,$where = "1=1",$values = array()){
   $sql =  $GLOBALS['con']->prepare("select $gewenstecolumen from $eersteTabel join $tweedeTable
      on $on where $where");
    $sql->execute($values);
    $row=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

// retuneert aantal records met join statment

function getDbDate(){
	$sql = $GLOBALS['con']->prepare("select CONVERT(date, SYSDATETIME())");
	$sql->execute();
	$date =$sql->fetchColumn();
	return $date;
}

function getDbTime(){
	$sql = $GLOBALS['con']->prepare("select CONVERT(time, SYSDATETIME())");
	$sql->execute();
	$time =$sql->fetchColumn();
	return $time;
}


function selectAndCountJoin($eersteTabel,$tweedeTable,$on,$where= "1=1",$values = array()){
   $sql =  $GLOBALS['con']->prepare("select count(*) from $eersteTabel join $tweedeTable
      on $on where $where;");
    $sql->execute($values);
    $row=$sql->fetchColumn();
    return $row;
}
//retuneert aantal records met where statment
function selectAndCountWhere($table,$where = '1=1',$values = array()){
   $sql = $GLOBALS['con']->prepare("select count(*) from $table where $where");
   $sql->execute($values);
   $row=$sql->fetchColumn();
   return $row;
}
//retuneert alle records met where statment
function selectWhere($column = '*',$table, $where = '1=1', $values = array()){
   $sql =  $GLOBALS['con']->prepare("select $column from $table where $where");
   $sql->execute($values);
   $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   return $row;
}
// update naar nieuwe waarde met een where statement
function updateWhere($rubriek, $nieuwewaarde, $where){
$sql =  $GLOBALS['con']->prepare("update $rubriek set $nieuwewaarde where rubrieknummer = $where");
   $sql->execute($values);
   $row=$sql->fetchAll(PDO::FETCH_ASSOC);
}

function selectOrderBy($column = '*',$table, $order, $values = array()){
   $sql =  $GLOBALS['con']->prepare("select $column from $table order by $order");
   $sql->execute($values);
   $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   return $row;
}

function selectWhereGroupBy($column = '*',$table, $where, $group, $values = array()){
   $sql =  $GLOBALS['con']->prepare("select $column from $table where $where group by $group");
   $sql->execute($values);
   $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   return $row;
}

function selectWhereOrderBy($column = '*',$table, $where, $order, $values = array()){
   $sql =  $GLOBALS['con']->prepare("select $column from $table where $where order by $order");
   $sql->execute($values);
   $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   return $row;
}

//Retuneert de startprijs van een item
function selectStartprijsWhere($nummer){
   $sql =  $GLOBALS['con']->prepare("select Startprijs from Voorwerp where voorwerpnummer = $nummer");
   $sql->execute();
   $row=$sql->fetchALL(PDO::FETCH_ASSOC);

   $prijs;
   foreach($row as $item){
	   $prijs = $item['Startprijs'];
   }
   return $prijs;
}
//Retuneert het hoogste bod(prijs) van een item
function selecthoogsteWhere($nummer){
   $sql =  $GLOBALS['con']->prepare("select verkopprijs from Voorwerp where voorwerpnummer = $nummer");
   $sql->execute();
   $row=$sql->fetchALL(PDO::FETCH_ASSOC);

   $prijs;
   foreach($row as $item){
	   $prijs = $item['verkopprijs'];
   }
   return $prijs;
}

function selectTussenPrijs($prijs1, $prijs2){
   $sql =  $GLOBALS['con']->prepare("select * from Voorwerp where verkopprijs > $prijs1 AND verkopprijs < $prijs2");
   $sql->execute();
   $row=$sql->fetchALL(PDO::FETCH_ASSOC);
   return $row;
}

function selectEindeDagWhere($nummer){
   $sql =  $GLOBALS['con']->prepare("select looptijdeindeDag from Voorwerp where voorwerpnummer = $nummer");
   $sql->execute();
   $row=$sql->fetchALL(PDO::FETCH_ASSOC);

   $datum;
   foreach($row as $item){
	   $datum = $item['looptijdeindeDag'];
   }
   return $datum;
}

function selectEindeTijdWhere($nummer){
   $sql =  $GLOBALS['con']->prepare("select looptijdeindetijdstip from Voorwerp where voorwerpnummer = $nummer");
   $sql->execute();
   $row=$sql->fetchALL(PDO::FETCH_ASSOC);

   $tijd;
   foreach($row as $item){
	   $tijd = $item['looptijdeindetijdstip'];
   }
   return $tijd;
}

function isVerkoper($username){
  $item;
  $sql =  $GLOBALS['con']->prepare("select Verkoper from gebruiker where Gebruikersnaam like '$username'");
   $sql->execute();
   $item=$sql->fetchAll(PDO::FETCH_ASSOC);

  if(isset($item[0])){
    if($item[0]['Verkoper'] == 1){
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
}

function isBeheerder($username){
  $item;
  $sql =  $GLOBALS['con']->prepare("select role from gebruiker where Gebruikersnaam like '$username'");
   $sql->execute();
   $item=$sql->fetchAll(PDO::FETCH_ASSOC);

  if(isset($item[0])){
    if($item[0]['role'] == 1){
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
}


//insert in de tabelen

function insert($tableName,$columns,$howmany,$values){
  $sql =  $GLOBALS['con']->prepare("insert into $tableName($columns) values($howmany)");
  $sql->execute($values);
  return $sql->rowCount();
}

//een record verwijderen

function delete($tableName,$condition,$values){
  $sql =  $GLOBALS['con']->prepare("delete from $tableName where $condition ");
  $sql->execute($values);
  return $sql->rowCount();
}


function textKeeper($name){
  if(isset($_GET[$name])){
    return $_GET[$name];
  }elseif(isset($_POSt[$name])){
    return $_POSt[$name];
  }
  return null;
}

function validation($source, $items = array()){
    $erros = array();
    foreach ($items as $item => $rules) {
      foreach ($rules as $rule => $rule_value) {
        $value = trim($source[$item]);
        // echo $value;
        if($rule ===  'verplicht' && empty($value)){
          $erros[] = $item. ' is ' .$rule;
        }
        if($rule === 'letters' && !preg_match("/^[a-zA-Z ]*$/",$value)){
          $erros[] = $item. ' kan alleen ' .$rule.' bevatten';
        }
        if($rule === 'nummers' && !preg_match("/^[0-9]*$/",$value)){
          $erros[] = $item. ' kan alleen ' .$rule.' bevatten';
        }
        elseif (!empty($value)) {
           switch ($rule) {
             case 'min':
               if (strlen($value)<$rule_value) {
                 $erros[] = $item. ' moet meer dan ' .$rule_value;
               }
               break;
               case 'max':
               if (strlen($value)>$rule_value) {
                 $erros[] = $item. ' moet maximaal ' .$rule_value.' karakter';
               }
               break;
           }
        }
      }
    }
    return $erros;
}
function Aantal_items($countitems , $gewenstecolumen, $eersteTabel, $tweedeTable, $on, $derdeTable, $tweedeON, $groupby, $rubriekNummer, $values = array()){
	   $sql =  $GLOBALS['con']->prepare
	   ("select count($countitems) as 'aantal' ,$gewenstecolumen
from $eersteTabel left outer join $tweedeTable
on $on
left outer join $derdeTable
on $tweedeON
where R.rubriek = $rubriekNummer
group by $groupby");
    $sql->execute($values);
    $row=$sql->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}


?>
