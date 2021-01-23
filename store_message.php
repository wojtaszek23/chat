<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "connection_strings.php";
  
  if($_SERVER['REQUEST_METHOD'] != "POST")
  {
    exit();
  }
  
  //$session_id = session_id();
  $text = $_POST['text'];
  $nick = $_SESSION['nick_logged'];
  $connection = new mysqli($host, $db_user, $password, $db_name);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  $connection->query("INSERT INTO chat_messages (nick, text) VALUES ('$nick', '$text')");
  $connection->close();
?>
