<?php
  //open access to session variables
  session_start();  
  
  //set flag that validation passed ok
  $ok = true;

  //set variables from form to local variables 
  $_SESSION['nick'] = $nick = $_POST['nick'];
  $_SESSION['email'] = $email = $_POST['email'];
  $_SESSION['password1'] = $password1 = $_POST['password1'];
  $_SESSION['password2'] = $password2 = $_POST['password2'];
  $_SESSION['first_name'] = $first_name = $_POST['first_name'];
  $_SESSION['last_name'] = $last_name = $_POST['last_name'];
  

  //check if nick was provided
  if($nick == null)
  {
    $ok = false;
    $_SESSION['e_nick'] = "Proszę podać nick.";
  }
  //check if nick has >2 and <21 characters
  else if(strlen($nick) < 3 || strlen($nick) > 20)
  {
    $ok = false;
    $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków.";
  }
  //check if nick consists only from valid characters
  else if(ctype_alnum($nick) == false)
  {
    $ok = false;
    $_SESSION['e_nick'] = "Nick musi składać się tylko z liter i cyfr (bez polskich znaków).";
  }
  
  //check if email was provided
  if($email == null)
  {
    $ok = false;
    $_SESSION['e_email'] = "Proszę podać adres e-mail.";
  }
  else
  {
    //make filterization of email and store it for comparision
    $emailSanitizied=filter_var($email, FILTER_SANITIZE_EMAIL);
    
    //check if email is valid
    if(filter_var($emailSanitizied, FILTER_VALIDATE_EMAIL)==false || ($emailSanitizied!=$email))
    {
      $ok = false;
      $_SESSION['e_email'] = "Podany adres e-mail jest niepoprawny.";
    }
  }
  
  //check if password was provided
  if($password1 == null)
  {
    $ok = false;
    $_SESSION['e_password'] = "Proszę wprowadzić hasło.";
  }
  //check if repeated password is equal to the first one
  else if($password1 != $password2)
  {
    $ok = false;
    $_SESSION['e_password'] = "Podane hasła muszą być identyczne.";
  }
  
  //hash the password
  $passw_hash = password_hash($password1, PASSWORD_DEFAULT);

  require_once "connection_strings.php";
  
  //if every field provided by user has correct syntax
  if($ok == true)
  {
    try
    {
      //access new connection with db
      $connection = new mysqli($host, $db_user, $password, $db_name);
      //connection with server db failed
      if($connection->connect_errno != 0)
      {
        throw new Exception(mysqli_connect_errno());
      }   
      //is that nick arleady in use?
      $result = $connection->query("SELECT id from users where nick='$nick'");
      $nick_nums = $result->num_rows;
      //is any?
      if($nick_nums > 0)
      {
        $_SESSION['e_nick'] = "Podany Nick jest już zarezerwowany. Proszę podać inny.";
        $ok = false;
      }
      
      //is that email arleady in use?
      $result = $connection->query("SELECT id from users where email='$email'");
      $email_nums = $result->num_rows;
      //is any?
      if($email_nums > 0)
      {
        $_SESSION['e_email'] = "Podany adres e-mail jest już zarezerwowany. Proszę podać inny.";
        $ok = false;
      }
      
      if($ok == false)
      {
        header('location: registration.php');
        exit();
      }
      
      if($ok == true)
      {
        if( $connection->query("INSERT INTO users (nick, email, password, first_name, last_name, joining_time)
         VALUES ('$nick', '$email', '$passw_hash', '$first_name', '$last_name', now())") == true)
        {
          $connection->close();
          session_reset();
          $_SESSION['registration_approved'] = true;
          header('location: login.php');
          exit();
        }
        else
        {
          throw new Exception($connection->error);
        }
      }
      $connection->close();
      exit();
    }
    catch(Exception $e)
    {
      echo '<span style="color:red;">Błąd serwera. Proszę o kontakt z administratorem lub zajrzenie tutaj w innym terminie.</span>';
      exit();
    }
  }
  else
  {
    header('location: registration.php');
    exit();
  }
?>
