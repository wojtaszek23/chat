<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "connection_strings.php";
  
  //exit if type of http request is other than get, only get is expected.
  //exit if there is no nick set in session or user is no logged in session also.
  if($_SERVER['REQUEST_METHOD'] != "GET" || !isset($_SESSION['nick_logged']) || $_SESSION['logged']!=true)
  {
    exit();
  }
  
  $nick = $_SESSION['nick_logged'];
  
  //create a new connection to sql database
  $connection = new mysqli($host, $db_user, $password, $db_name);
  
  //if some error occured while creating mysqli object or attempting connection with database 
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  //set logged value to true for user who asks about other logged users in database
  $connection->query("UPDATE users set logged=true where nick='$nick'"); 
  //take records with logged users
  $result = $connection->query("SELECT nick from users where logged=true");
  //constructor of array in php xD
  $users = array();
  
  //fetch all rows from result
  while($row = $result->fetch_assoc())
  {
    //syntax of assigning new element to php array xD
    $users[] = $row;
  }
  $connection->close();
  
  echo json_encode($users);
?>
