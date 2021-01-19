<?php
  //open access to session variables
  session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8"/>
  <title>Rejestracja</title>
  <link rel="stylesheet" href="./css/registration.css" type="text/css" />
</head>
<body>
  <div id="header">
    Aby się zarejetrować, należy wypełnić formularz podając swój nick, email oraz hasło. Jeśli jednak chcesz, proszę Cię również o podanie imienia i nazwiska,
    </br> abym mógł skojarzyć Cię w przypadku, jeśli się znamy.
  </div>
  <form action="try_registration.php" method="post">
    Nick: </br>
    <input type="text" name="nick" value="<?php
      if(isset($_SESSION['nick']))
      {
	echo $_SESSION['nick'];
      }
    ?>"/> <span class="error">* <?php
      if(isset($_SESSION['e_nick']))
      {
	echo $_SESSION['e_nick'];
	unset($_SESSION['e_nick']);
      }
    ?></span> </br>
    Adres e-mail: </br>
    <input type="text" name="email" value="<?php
      if(isset($_SESSION['email']))
      {
	echo $_SESSION['email'];
      }
    ?>"/> <span class="error">* <?php
      if(isset($_SESSION['e_email']))
      {
	echo $_SESSION['e_email'];
	unset($_SESSION['e_email']);
      }
    ?></span> </br>
    Hasło: </br>
    <input type="password" name="password1"/ value="<?php
      if(isset($_SESSION['password1']))
      {
	echo $_SESSION['password1'];
      }
    ?>"> <span class="error">* <?php
      if(isset($_SESSION['e_password']))
      {
	echo $_SESSION['e_password'];
	unset($_SESSION['e_password']);
      }
    ?></span> </br>
    Proszę o powtórzenie hasła: </br>
    <input type="password" name="password2"/ value="<?php
      if(isset($_SESSION['password2']))
      {
	echo $_SESSION['password2'];
      }
    ?>"> </br>
    Imię: </br>
    <input type="text" name="first_name" value="<?php
      if(isset($_SESSION['first_name']))
      {
	echo $_SESSION['first_name'];
      }
    ?>"/> </br>
    Nazwisko: </br>
    <input type="text" name="last_name" value="<?php
      if(isset($_SESSION['last_name']))
      {
	echo $_SESSION['last_name'];
      }
    ?>"/>
    </br>
    <span class="error">* oznacza pola wymagane</span>
    </br></br>
    <input type="submit" value="Dokonanie rejestracji z wprowadzonymi danymi" />
  </form>
</body>
</html>
