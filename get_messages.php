<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "../connection_strings.php";
  
  //exit if type of http request is other than get, only get is expected.
  //exit if there is no nick set in session or user is no logged in session also.
  //exit if id of last message was not send from client side in a get http request.
  if($_SERVER['REQUEST_METHOD'] != "GET" || !isset($_SESSION['nick_logged']) || $_SESSION['logged']!=true)
  {
    exit();
  }
  else if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  {
    exit();
  }
  
  //store id of last message to local variable
  $last_id = $_GET['id'];
  $last_id = htmlentities($last_id, ENT_QUOTES, "UTF-8");
  
  //create a new connection to sql database
  $connection = new mysqli($host, $db_user, $password, $db_name_chat);
  
  //if some error occured while creating mysqli object or attempting connection with database 
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  //take records with logged users
  $result = $connection->query("SELECT * from chat_messages where id>'$last_id' order by id asc");
  //constructor of array in php xD
  $messages = array();
  
  //fetch all rows from result
  while($row = $result->fetch_assoc())
  {
    //syntax of assigning new element to php array xD
    $messages[] = $row;
  }
  $connection->close();

  if($messages) echo json_encode($messages);
?>
