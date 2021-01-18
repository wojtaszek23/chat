<?php
  //open access to session variables
  session_start();
  
  if(!isset($_POST['nick']) || !isset($_POST['password']))
  {
    header('Location: login.php');
    exit();
  }
  
  $nick = $_POST['nick'];
  $password1 = $_POST['password'];
  
  if($nick == "")
  {
    $_SESSION['header_text'] = "Nie podano nicku. Proszę go uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  $nick = $_SESSION['nick'] = $_POST['nick'];
  
  if($password1 == "")
  {
    $_SESSION['header_text'] = "Nie podano hasła. Proszę je uzupełnić i ponownie wybrać akcję logowania.";
    header('location: login.php');
    exit();
  }
  
  $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
  
  require_once "connection_strings.php";
  
  $connection = new mysqli($host, $db_user, $password, $db_name);
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  else
  {
    $result = $connection->query("SELECT * from users where nick='$nick'");
    
    if($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();
      if(password_verify($password1, $row['password']))
      {
        $result->close();
        $connection->close();
        $_SESSION['logged'] = true;
        $_SESSION['nick_logged'] = $row['nick'];
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
