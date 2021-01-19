<?php
  //open access to session variables
  session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Logowanie na czacie</title>
  <link rel="stylesheet" href="./css/login.css" type="text/css" />
</head>
<body>
  <span id="header"><?php echo $_SESSION['header_text']; unset($_SESSION['header_text']); ?></span> </br> </br>
  <form id="form" action="try_login.php" method="post" style="clear:both">
    Nick: </br>
    <input type="text" name="nick" value="<?php
      if(isset($_SESSION['nick']) == true)
      {
	echo $_SESSION['nick'];
	unset($_SESSION['nick']);
      }
    ?>" /> </br>
    Hasło: </br>
    <input type="password" name="password"/> </br>
    </br>
    <input type="submit" value="Logowanie" />
  </form> 
</body>
</html>
