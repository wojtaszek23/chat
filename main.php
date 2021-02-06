<?php
  //open access to session variables
  session_start();
  //if there is no logged user
  if(!isset($_SESSION['nick_logged']) || $_SESSION['logged'] == false)
  {
    //return to chat initial screen
    header('location: ./welcome.php');
    //stop reading this file to load url above imidiately
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Czat</title>
  <link rel="stylesheet" href="./css/main.css" type="text/css" />
  
</head>
<body>
  <div id="talk_view_window"></div>
  <a href="./logout.php">
    <input type="button" id="logout_button" value="Wylogowanie"></input>
  </a>
  <div id="talk_choice_window">
    <div id="users_list_title"><b>Użytkownicy</b></div>
    <div id="users_list_window"></div>
    <div id="talks_list_title"><b>Rozmowy</b></div>
    <div id="talks_list_window"></div>
    <div id="current_talk_title"><b>Czat Ogólny</b></div>
    <div id="talk_participians_list">
      
    </div>
  </div>
  <textarea id="typing_window" name="typing_window" type="text"></textarea>
  <div id="talk_panel">
    <input type="button" id="send_button" value="Wysłanie wiadomości" onclick="sendMessage()"></input>
    <input type="button" id="new_talk_button" value="Nowa rozmowa" onClick="showNewTalkPanel()"></input>
    <input type="button" id="edit_talk_button" value="Edycja obecnej rozmowy"></input>
    <input type="button" id="add_person_to_talk" value="Dodanie rozmówcy"></input>
    <input type="button" id="remove_person_from_talk" value="Usunięcie rozmówcy"></input>
    <input type="button" id="next_choose_talk_title_button" value="Dalej / Wybór tytułu" onClick="chooseTitleOfNewTalk()"></input>
    <label id="new_talk_title_label"><b>Tytuł: </b></label>
    <input type="text" id="new_talk_title_textbox"></input>
    <input type="button" id="apply_new_talk" value="Zatwierdzenie nowej rozmowy" onClick="applyNewTalk()"></input> 
  </div>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
