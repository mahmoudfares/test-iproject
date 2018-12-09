<?php
$host = 'mssql.iproject.icasites.nl';
$database = 'iproject11';
$db_username = 'iproject11';
$db_pw = 'yGFXnDJ6kT';

try
{
    $con = new PDO("sqlsrv:Server=$host,1433;Database=$database;ConnectionPooling=0", $db_username, $db_pw);
    $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}catch(PDOexception $e){
   echo $e->getmessage();
}
?>
