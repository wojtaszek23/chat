<?php
  //open access to session variables
  session_start();
  //when user was currently logged
  if($_SESSION['logged']==true || $_SESSION['nick_logged'] != "")
  {
    //store user nick before session reset - that means, clear data of current session
    $nick_logout = $_SESSION['nick_logged'];
    //clear data of current session
    session_reset();
    //store nick name in session variable to write it on a page
    $_SESSION['nick_logout'] = $nick_logout;
    
    //attach connection strings to Database
    require_once "connection_strings.php";
    
    //create mysqli object and set connection strings throught constructor parameters,
    //that constructor opens a new connection with Database also
    $connection = new mysqli($host, $db_user, $password, $db_name);
    
    //if some error occured while try of access connection with Database
    if($connection->connect_errno != 0)
    {
      throw new Exception(myslqi_connect_errno());
    }
    
    $connection->query("UPDATE users set last_activity_time=NOW() where nick='$nick_logout'");
    
    $connection->query("UPDATE users set logged=false where nick='$nick_logout'");
    
    $connection->close();
  }
  else
  {
    //return to welcome page
    header('location: ./welcome.php');
    //leave this url imidiately
    exit();
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
