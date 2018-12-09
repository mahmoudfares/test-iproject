<?php
$host = 'localhost';
$database = 'EenmaalAndermaal';
$username = 'sa';
$pw = 'dbsql';

try{
    $con = new PDO("sqlsrv:Server=$host;Database=$database", "$username", "$pw");
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOexception $e){
   echo $e->getmessage();
}
?>
