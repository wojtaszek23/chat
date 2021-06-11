<?php
  //open access to session variables
  session_start();
  //attach connection strings to Database
  require_once "../connection_strings.php";
  
  /*
  if($_SERVER['REQUEST_METHOD'] != "POST")
  {
    exit();
  }
  */
  
  /*
  $text = $_POST['text'];
  $text = htmlentities($text, ENT_QUOTES, "UTF-8");
  $nick = $_SESSION['nick_logged'];
  $nick = htmlentities($nick);*/
  $connection = new mysqli($host, $db_user, $password, $db_name_chat);
  
  
  if($connection->connect_errno != 0)
  {
    throw new Exception(myslqi_connect_errno());
  }
  
  
  $connection->query("CREATE TABLE `chat_messages2` (
    `id` int(11) NOT NULL,
    `dateTime` datetime NOT NULL DEFAULT current_timestamp(),
    `nick` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `text` text COLLATE utf8mb4_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  
  $connection->query("ALTER TABLE `chat_messages2`
    ADD PRIMARY KEY (`id`)");
    
  $connection->query("ALTER TABLE `chat_messages2`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148");
  
  $connection->close();
  
  echo "done korleone";
  
  /*
  $connection->query("
    CREATE TABLE `chat_messages2` (
    `id` int(11) NOT NULL,
    `dateTime` datetime NOT NULL DEFAULT current_timestamp(),
    `nick` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `text` text COLLATE utf8mb4_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

  ALTER TABLE `chat_messages`
    ADD PRIMARY KEY (`id`);
    
  ALTER TABLE `chat_messages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
  ");
  */
?>


