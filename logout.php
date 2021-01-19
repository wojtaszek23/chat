<?php
  session_start();
  if($_SESSION['logged']==true || $_SESSION['nick_logged'] != "")
  {
    $nick_logout = $_SESSION['nick_logged'];
    session_unset();
    session_start();
    $_SESSION['nick_logout'] = $nick_logout;
  }
  else
  {
    header('location: ./welcome.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Czat</title>
  <link rel="stylesheet" href="./css/logout.css" type="text/css" />
</head>
<body>
  <span id="header">
    Nastąpiło wylogowanie użytkownika o nicku <b><?php echo $_SESSION['nick_logout']; unset($_SESSION['nick_logout']);?></b>.</br>
    W celu ponownego zalogowania, należy <a href="./login.php">kliknąć tu</a>.
  </span>
</body>
</html>
