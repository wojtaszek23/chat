<?php
  //open access to session variables
  session_start();
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    header('location: ./welcome.php');
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Czat</title>
  <link rel="stylesheet" href="./css/main.css" type="text/css" />
</head>
<body>
  <div id="main_chat_window"></div>
  <a href="./logout.php">
    <input type="button" id="logout_button" value="Wylogowanie"></input>
  </a>
  <div id="users_window"></div>
  <textarea id="typing_window" name="typing_window" type="text"></textarea>
  <input type="button" id="send_button" value="Wysłanie wiadomości"></input>
</body>
</html>
