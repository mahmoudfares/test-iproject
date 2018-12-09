<?php
session_start();

if(isset($_SESSION["username"])){
  $loggedInUser = $_SESSION["username"];
}else{
  $loggedInUser = "NOTLOGGEDIN";
}

function echoHead($title){


$output =
'<!DOCTYPE html>
  <html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="recources/css/bootstrap.css">
    <link rel="stylesheet" href="recources/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="recources/css/style.css">
    <!-- <link rel="stylesheet" href="recources/css/styleM.css"> -->
  </head>';
  echo $output;
}
?>
