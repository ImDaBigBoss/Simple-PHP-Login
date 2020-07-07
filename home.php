<?php

session_start();
$all = "";

if (isset($_POST["sent"]) == false) {
  $all = $_SESSION["all"];
  $pass = explode(":", $all)[1];
  $user = explode(":", $all)[0];
} else {
  $pass = hash('sha512', $_POST["pass"]);
  $user = $_POST["user"];
  
  $all = "$user:$pass";
  
  $_SESSION["all"] = $all;
}

$err = 1;
if ($_POST["action"] == "log") {
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
} elseif ($_POST["action"] == "sign") {
  $found = true;
  if (file_exists(__DIR__ . "/accounts/$user.txt")) {
    $err = 2;
    $found = false;
  } else {
    file_put_contents(__DIR__  . "/accounts/$user.txt", $pass);
  }
}

if ($found == false) {
  session_unset(); 
  session_destroy();
  
  header("Location: index.php?e=$err");

  exit();
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
