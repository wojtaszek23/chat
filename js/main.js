var id = 0;
var talk_choice_window = document.getElementById("users_list_window");


function printUsersList(jsonUsersList)
{
  talk_choice_window.innerHTML = "";
  
  for(var i=0; i<jsonUsersList.length; i++)
  {
    var user = jsonUsersList[i];
    talk_choice_window.innerHTML = talk_choice_window.innerHTML + '<span class="user" id="' + user.nick + '">' + user.nick + '</span>';
  }
}

function addNewMessages(jsonMessages)
{
  var chat = document.getElementById("talk_view_window");
  var scrollDownFlag = false;
  
  //scrollHeight - pixels value of entire area of element- containing both- hidden and visible content
  //scrollTop - pixels value of area from beggining of element to beggining (top) of currently showed (scrolled) content
  //clientHeight - pixels value of showed area of element
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
  chat.scrollTop = chat.scrollHeight; //scrollHeight will be always greater than maximum value of scrollTop
}

function getMessages()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./get_messages.php";
  
  xmlhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200) 
    {
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
	talk_choice_window.innerHTML = 
	'<span class="error" id="talk_choice_window_error">Wystąpił błąd serwera podczas próby pobrania listy aktualnie zalogowanych użytkowników</span>';
      }
    }
  };
  
  xmlhttp.open("GET", url, true);
  try
  {
    xmlhttp.send();
  }
  catch(e)
  {
    document.getElementById("users_list_window").innerHTML = e;
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

function setCatchingReturnKeyOnTypingWindow()
{
  document.getElementById('typing_window').addEventListener('keydown', function(e){
    if (e.keyCode === 13 && !e.shiftKey){
      e.preventDefault();
      if (document.getElementById('typing_window') != "")
      {
	sendMessage();
      }
    }
  }
  );
}

function applyNewTalk()
{
  document.getElementById('new_talk_button').style="display: block;";
  document.getElementById('edit_talk_button').style="display: block;";
  document.getElementById('add_person_to_talk').style="display: none;";
  document.getElementById('remove_person_from_talk').style="display: none;";
  document.getElementById('next_choose_talk_title_button').style="display: none;";
  document.getElementById('new_talk_title_label').style="display: none;";
  document.getElementById('new_talk_title_textbox').style="display: none;";
  document.getElementById('apply_new_talk').style="display: none;";
}

function chooseTitleOfNewTalk()
{
  document.getElementById('new_talk_button').style="display: none;";
  document.getElementById('edit_talk_button').style="display: none;";
  document.getElementById('add_person_to_talk').style="display: none;";
  document.getElementById('remove_person_from_talk').style="display: none;";
  document.getElementById('next_choose_talk_title_button').style="display: none;";
  document.getElementById('new_talk_title_label').style="display: block;";
  document.getElementById('new_talk_title_textbox').style="display: block;";
  document.getElementById('apply_new_talk').style="display: block;";
}

function showNewTalkPanel()
{
  document.getElementById('new_talk_title_label').style="display: none;";
  document.getElementById('new_talk_title_textbox').style="display: none;";
  document.getElementById('apply_new_talk').style="display: none;";
  document.getElementById('new_talk_button').style="display: none;";
  document.getElementById('edit_talk_button').style="display: none;";
  document.getElementById('add_person_to_talk').style="display: block;";
  document.getElementById('remove_person_from_talk').style="display: block;";
  document.getElementById('next_choose_talk_title_button').style="display: block;";
  document.getElementById('current_talk_title').innerHTML="<b>[Nowa rozmowa]</b>";
}

function loadScript()
{
  setCatchingReturnKeyOnTypingWindow();
  processUsersList();
  processMessages();
}

function abc()
{
  var xmlhttp = new XMLHttpRequest();
  var url = "./create_new_talk.php";
  
  xmlhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200) 
    {
      console.log(this.responseText);
    }
  };
  
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}

document.addEventListener("DOMContentLoaded",loadScript);
