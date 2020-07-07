<?php

session_start();
$all = "";

if (isset($_POST["text"]) == false) {
  header("Location: home.php");
}

$all = $_SESSION["all"];
$pass = explode(":", $all)[1];
$user = explode(":", $all)[0];

$found = false;
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

file_put_contents("my/file", $_POST["text"]);
header("Location: home.php");

?>
