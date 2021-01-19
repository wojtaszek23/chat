var id = 0;



function printUsersList(jsonUsersList)
{
  var users_window = document.getElementById("users_window");
  
  users_window.innerHTML = "";
  
  for(var i=0; i<jsonUsersList.users.length; i++)
  {
    var user = jsonUsersList.users[i];
    users_window.innerHTML = users_window.innerHTML + '<span class="users" id="' + user + '">' + user + '</span>';
  }
}

function addNewMessages(jsonMessages)
{
  var chat = document.getElementById("main_chat_window");
  
  for(var i=0; i<jsonMessages.messages.length; i++)
  {
    var msg = jsonMessages.messages[i];
    chat.innerHTML = chat.innerHTML + msg.dateTime + " <b>" + msg.nick + ": </b>" + msg.message + "</br>";
    id = msg.id;
  }
}

function getMessages()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./get_messages.php";
  
  xmlhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200) {
      var messages = JSON.parse(this.responseText);
      addNewMessages(messages);
    }
  };
  
  xmlhttp.open("GET", url+"?q="+id, true);
  xmlhttp.send();
}

function getUsersList()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./get_users_list.php";
  
  xmlhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200) {
      var messages = JSON.parse(this.responseText);
      addNewMessages(messages);
    }
  };
  
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}

function processMessages()
{
  getMessages();
  setTimeout(processMessages, 5000);
}

function processUsersList()
{
  getUsersList();
  setTimeout(processUsersList, 60000);
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
/*
var obj = JSON.parse('{' +
' "users": [' +
' "Andrzej", ' +
' "Barbara", ' +
' "Bożydar" ] ' +
'}');

printUsersList(obj);

var obj2 = JSON.parse(
'{'+
'	"messages": [{'+
'			"dateTime": "01.10.1991 15:40:32",'+
'			"nick": "Jaś Fasola",'+
'			"message": "dupa sraka"'+
'		},'+
'		{'+
'			"dateTime": "25.03.2002 14:20:07",'+
'			"nick": "Korybut Wiśniowiecki",'+
'			"message": "chrząsz brzmi w trzcinie, gdzieś tam."'+
'		}'+
'	]'+
'}');

addNewMessages(obj2);
*/
