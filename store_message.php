<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "connection_strings.php";
  
  if($_SERVER['REQUEST_METHOD'] != "POST")
  {
    exit();
  }
  
  $text = $_POST['text'];
  $text = htmlentities($text, ENT_QUOTES, "UTF-8");
  $nick = $_SESSION['nick_logged'];
  $nick = htmlentities($nick);
  $connection = new mysqli($host, $db_user, $password, $db_name);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  $connection->query("INSERT INTO chat_messages (nick, text) VALUES ('$nick', '$text')");
  $connection->close();
?>
