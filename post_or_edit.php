<?php

session_start(); //Start the php session
$all = "";

if (isset($_POST["text"]) == false) { //Get if any text was actually sent
  header("Location: home.php"); //If not redirect home
}

$all = $_SESSION["all"]; //Get the login details saved on the home page
$pass = explode(":", $all)[1];
$user = explode(":", $all)[0];

$found = false; //Check the account (see home.php)
$directory = __DIR__  . "/accounts/";
$files = array_diff(scandir($directory), array('..', '.'));

foreach ($files as &$value) {
  $value2 = substr($value, 0, -4);
  $nall = explode(":", $all);
    
  if ($value2 == $nall[0]) {
    $cont = file_get_contents(__DIR__  . "/accounts/" . $value);
    if ($cont == $nall[1]) {
      $found = true;
    }
  }
}

if ($found == false) {
  session_unset(); 
  session_destroy();
  
  header("Location: index.php?e=1");

  exit();
}

file_put_contents("my/file", $_POST["text"]); //Save the text to a file
header("Location: home.php"); //redirect home

?>
