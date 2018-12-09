<?php
$host = 'mssql.iproject.icasites.nl';
$database = 'iproject11';
$username = 'iproject11';
$pw = 'yGFXnDJ6kT';

try{
    $con = new PDO("sqlsrv:Server=$host;Database=$database", "$username", "$pw");
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOexception $e){
   echo $e->getmessage();
}
?>
