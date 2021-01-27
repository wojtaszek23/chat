<?php
  //attach connection strings to Database
  require_once "connection_strings.php";
  
  //create a new connection to sql database
  $connection = new mysqli($host, $db_user, $password, $db_name);
  
  //if some error occured while creating mysqli object or attempting connection with database 
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  //set logged value to false for users who has been passive for more than 2 minutes
  $connection->query("UPDATE users set logged=false where last_activity_time < NOW() - INTERVAL 60 second");
  $connection->close();
  
?>
