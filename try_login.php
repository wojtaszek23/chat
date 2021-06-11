<?php
  //open access to session variables
  session_start();
  
  //if nick or password is not set in session
  if(!isset($_POST['nick']) || !isset($_POST['password']))
  {
    header('Location: login.php');
    exit();
  }
  
  //store nick provided by user to session and local variables
  $nick = $_SESSION['nick'] = $_POST['nick'];
  
  //if provided nick consists of empty string
  if($nick == "")
  {
    //create inform text and imidiately back with it to login page
    $_SESSION['header_text'] = "Nie podano nicku. Proszę go uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  //store password provided by user to local variables
  $password1 = $_POST['password'];
  
  //if provided password consists of empty string
  if($password1 == "")
  {
    //create inform text and imidiately back with it to login page
    $_SESSION['header_text'] = "Nie podano hasła. Proszę je uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  //convert quotes if occur to html entities
  $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
  
  //attach connection strings to Database
  require_once "../connection_strings.php";
  
  //create mysqli object and set connection strings throught constructor parameters,
  //that constructor opens a new connection with Database also
  $connection = new mysqli($host, $db_user, $password, $db_name_users);
  
  //if some error occured while try of access connection with Database
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  //connection was established successfuly
  else
  {
    //find record with given user nick name
    $result = $connection->query("SELECT * from users where nick='$nick'");
    
    //successfuly there is some user with given nick name in Database
    if($result->num_rows > 0)
    {
      //group result to associative table and store it as row variable
      $row = $result->fetch_assoc();
      //check if given password suits to hashed version of password stored in Database
      if(password_verify($password1, $row['password']))
      {
        //release the resource
        $result->close();
        $connection->close();
        //will be used in main.php to validate that user is logged
        $_SESSION['logged'] = true;
        //will be used in main.php to store info about user nick name
        $_SESSION['nick_logged'] = $row['nick'];
        //move to the main chat (as logged user)
        header('location: main.php');
        exit();
      }
      else
      {
        $_SESSION['header_text'] = "Podane hasło jest nieprawidłowe.";
      }
    }
    else
    {
      $_SESSION['header_text'] = "Nie znaleziono podanego nicku w bazie danych.";
    }
    $connection->close();
    header('location: login.php');
    exit();
  }
  
?>
