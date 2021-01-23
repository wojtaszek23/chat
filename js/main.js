var id = 0;
var users_window = document.getElementById("users_window");


function printUsersList(jsonUsersList)
{
  users_window.innerHTML = "";
  
  for(var i=0; i<jsonUsersList.length; i++)
  {
    var user = jsonUsersList[i];
    users_window.innerHTML = users_window.innerHTML + '<span class="users" id="' + user.nick + '">' + user.nick + '</span>';
    console.log('<span class="users" id="' + user + '">' + user + '</span>');
  }
}

function addNewMessages(jsonMessages)
{
  var chat = document.getElementById("main_chat_window");
  var scrollDownFlag = false;
  
  //TODO: sprawdzić scrollHeight, scrollTop oraz clientHeight!!! co oznaczają te atrybuty
  if(chat.scrollHeight - chat.scrollTop - chat.clientHeight < 1)
  {
    scrollDownFlag = true;
  }
  
  for(var i=0; i<jsonMessages.length; i++)
  {
    var msg = jsonMessages[i];
    chat.innerHTML = chat.innerHTML + msg.dateTime + " <b>" + msg.nick + ": </b>" + msg.text + "</br>";
    id = msg.id;
  }
  
  if(scrollDownFlag)
  chat.scrollTop = chat.scrollHeight;
}

function getMessages()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./get_messages.php";
  
  xmlhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200) 
    {
      console.log(this.responseText);
      if(this.responseText!="")
      {
	var messages = JSON.parse(this.responseText);
	addNewMessages(messages);
      }
    }
  };
  
  xmlhttp.open("GET", url+"?id="+id, true);
  xmlhttp.send();
}

function getUsersList()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./get_users_list.php";
  
  xmlhttp.onreadystatechange = function(){
    if(this.readyState == 4)
    {
      if(this.status == 200)
      {
	var messages = JSON.parse(this.responseText);
	printUsersList(messages);
      }
      else
      {
	users_window.innerHTML = 
	'<span class="error" id="users_window_error">Wystąpił błąd serwera podczas próby pobrania listy aktualnie zalogowanych użytkowników</span>';
	console.log(this.readyState + " " + this.status);
      }
    }
  };
  
  xmlhttp.open("GET", url, true);
  try
  {
    console.log("blabalbla");
    xmlhttp.send();
  }
  catch(e)
  {
    console.log("kupo...");
    document.getElementById("users_window").innerHTML = e;
  }
  finally
  {
    console.log("nie ogarniam...");
  }
}

function processMessages()
{
  getMessages();
  setTimeout(processMessages, 2000);
}

function sendMessage()
{
  var text = document.getElementById('typing_window');
  var xmlhttp = new XMLHttpRequest();
  var url = "./store_message.php";
  xmlhttp.addEventListener("load", e => {
        if (xmlhttp.status === 200) {
            console.log(xmlhttp.response);
        }
    });
  xmlhttp.open("POST", url, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("text="+text.value);
  text.value="";
}

function processUsersList()
{
  getUsersList();
  setTimeout(processUsersList, 60000);
}

processUsersList();

processMessages();
