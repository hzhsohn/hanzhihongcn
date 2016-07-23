<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset=utf-8 /> 
<meta name="viewport" content="width=620" /> 
<title>Web Socket-&gt;Serial</title> 
<link rel="stylesheet" href="http://html5demos.com/css/html5demos.css" type="text/css" /> 
<style> 
#chat { width: 97%; }
.them { font-weight: bold; }
.them:before { content: 'feedback: '; color:#036; font-size: 14px; }
#log {
  overflow: auto;
  height: 300px;
  list-style: none;
  padding: 0;
  border:dotted;
  border-color:#CCC;
/*  margin: 0;*/
}
#log li {
  border-top: 1px solid #ccc;
  margin: 0;
  padding: 10px 0;
}
</style> 
</head> 
<body> 
<section id="wrapper"> <a href="../index.php">返回档案</a>
<header> 
    <h1>WebSocket -&gt; Serial</h1> 
note:the websocket send/recv buf must be escape() and unescape() transmission.
    </header> 

<article> 
    <input type="text" id="ipstr" value="127.0.0.1" size="16" placeholder="type ip" /> 
    <input type="text" id="portstr" value="7778" size="6" placeholder="type port" /> 
<input type="button" id="btnconnect" value="连接" /> 
    <input type="text" id="chat" value="0x63 0x00 0x04 0x00 0x6F 0x63 0x00 0x00 0xD2 0x6B" size="50" placeholder="type and press enter to chat" /> 
  <p id="status">Not connected</p> 
  <ul id="log"></ul> 
</article> 
<script>
//////////////////////////////////////////
//
function trCharToHexStr(buf) {
	var r="";
	var w = new Array();
	var hexes = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
	for (var i=0; i<buf.length; i++)
	{
		r +='0x'+ hexes [buf.charCodeAt(i) >> 4] + hexes [buf.charCodeAt(i) & 0xf]+' ';
	}
	return r;
}
function trHexStrToSend(str)
{
	var ret="";
	var ch = new Array;
	ch = str.split(" ");
	for(i=0;i<ch.length;i++)
	{ret+=String.fromCharCode(parseInt(ch[i],16));}
	return escape(ret);
}

//////////////////////////////////////////
//websocket
function openConnection() {
  // uses global 'conn' object
  if (conn.readyState === undefined || conn.readyState > 1) {
    conn = new WebSocket('ws://'+ipstr.value+':'+portstr.value); 
    conn.onopen = function () {
      state.className = 'success';
      state.innerHTML = 'Socket open';
    };
 
    conn.onmessage = function (event) {
      var message = trCharToHexStr(unescape(event.data));
      log.innerHTML =log.innerHTML+ '<li class="them">' + message + '</li>';
	  log.scrollTop=log.scrollHeight;
    };
    
    conn.onclose = function (event) {
      state.className = 'fail';
      state.innerHTML = 'Socket closed';
      //重新连接
      //setTimeout(openConnection, 1000);
    };
  }
}

var log = document.getElementById('log'),
    chat = document.getElementById('chat'),
    conn = {},
    state = document.getElementById('status');
 
if (window.WebSocket === undefined) {
  state.innerHTML = 'Sockets not supported';
  state.className = 'fail';
}

chat.onkeyup=function(event) {
	// if we're connected
	if (event.keyCode==13&&conn.readyState === 1) {
	  conn.send(trHexStrToSend(chat.value.trim()));
	  //chat.value = '';
	}
};

btnconnect.onclick=function(event) {
	openConnection();
};

</script>
</section> 
</body> 
</html>