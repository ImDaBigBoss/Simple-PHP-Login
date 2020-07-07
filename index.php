<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - My site</title>
  </head>
  <body>
    <div style="height: 100px; position: fixed; left: 0px; top: 0px; background-color: lightblue; width: 100%;">
      <a href="/"><img alt="logo" src="/favicon.ico" height="80px" style="position: fixed; left: 10px; top: 10px; z-index: 2;"></a>
      <center><h1>My site</h1></center>
    </div>

    <h1 style="margin-top: 120px;">Welcome to my site!</h1>
    <h2>Log in / Sign up!</h2>
    <form method="POST" action="home.php">
        <label for="user">Username :</label><br />
        <input type="text" id="user" name="user" /><br />
        <label for="pass">Password :</label><br />
        <input type="password" id="pass" name="pass" /><br />
        <input type="radio" id="log" name="action" value="log" checked>
        <label for="log">Log in</label><br>
        <input type="radio" id="sign" name="action" value="sign">
        <label for="sign">Sign up</label><br>
        <input type="hidden" name="sent" value="true" />
        <input type="submit" value="Submit">
      </form>
      <?php
        if ($_GET["e"] == "1") {
          echo '<script>alert("Incorret details")</script>';
        }
        if ($_GET["e"] == "2") {
          echo '<script>alert("User already exists")</script>';
        }
      ?>
  </body>
</html>
