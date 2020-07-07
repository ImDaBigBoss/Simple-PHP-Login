<?php

session_start(); //start the php session
$all = "";

if (isset($_POST["sent"]) == false) { //check if the request was sent form main page or not
  $all = $_SESSION["all"]; //Get the data form previously stored variables
  $pass = explode(":", $all)[1];
  $user = explode(":", $all)[0];
} else {
  $pass = hash('sha512', $_POST["pass"]);//If it was, then log in/sign up with new details
  $user = $_POST["user"];
  
  $all = "$user:$pass";
  
  $_SESSION["all"] = $all;
}

$err = 1; //Set the defaumt error code
if ($_POST["action"] == "log") {//If logging in
  $found = false; //Set default to: account not found
  $directory = __DIR__  . "/accounts/";
  $files = array_diff(scandir($directory), array('..', '.'));

  foreach ($files as &$value) {
    $value2 = substr($value, 0, -4);
    $nall = explode(":", $all);
    
    if ($value2 == $nall[0]) { //If the user corresponds with the current file
      $cont = file_get_contents(__DIR__  . "/accounts/" . $value);
      if ($cont == $nall[1]) { //Get if the password corresponds to the selected user
        $found = true; //Yay, the user was found
      }
    }
  }
} elseif ($_POST["action"] == "sign") { //sign up
  $found = true; //The user has to have been found as it was just created
  if (file_exists(__DIR__ . "/accounts/$user.txt")) {
    $err = 2; //User alredy exists
    $found = false; //User not found: redirected to index.php
  } else {
    file_put_contents(__DIR__  . "/accounts/$user.txt", $pass); //Save the user
  }
}

if ($found == false) { //If the user was not found
  session_unset(); 
  session_destroy(); //remove all saved data
  
  header("Location: index.php?e=$err");//redirect to index.php with the selected error code

  exit(); // extra security if the redirect fails
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - My site</title>
  </head>
  <body>
    <div style="height: 100px; position: fixed; left: 0px; top: 0px; background-color: lightblue; width: 100%;">
      <a href="/"><img alt="logo" src="/favicon.ico" height="80px" style="position: fixed; left: 10px; top: 10px; z-index: 2;"></a>
      <center><h1>My site</h1></center>
    </div>

    <h1 style="margin-top: 120px;">Welcome <?php echo explode(":", $all)[0]; ?>!</h1>
  </body>
</html>
