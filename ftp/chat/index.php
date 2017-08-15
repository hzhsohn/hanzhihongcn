<?php
$wsadr=$_SERVER['SERVER_NAME'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Author" content="Han.zhihong." />
<meta name="Category" content="developer,apple,andrpoid,products" />
<meta name="Description" content="韩智鸿的小博客,本网站只是用来技术交流和生活记事..." />
<title>在线聊天</title>
<link href="css/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="divContent">
  <div id="divMid">
      <form id="frmChat">
        <p id="statusBar" class="chat_fail"><span id="status"><img src="image/index/chat_coct.gif"/> 正在连接到聊天室...</span><span style="float:right;" id="connected"></span></p>
        <ul id="log">
        </ul>
        <input type="text" id="nickname" placeholder="呢称"/>
        <input type="text" id="chat" maxlength="256" placeholder="回车发送消息"/>
      </form>
  </div>
  <div id="divFooter">
    <div id="divCopyright"> Design By Han.zh , 粤ICP备13015372号</div>
  </div>
</div>

<script>
//写cookies 
function setCookie(name,value) 
{ 
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
} 
//读取cookies 
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
} 

var cookie_username=getCookie("hzhChatUser");

var addEvent = (function () {
  if (document.addEventListener) {
    return function (el, type, fn) {
      if (el && el.nodeName || el === window) {
        el.addEventListener(type, fn, false);
      } else if (el && el.length) {
        for (var i = 0; i < el.length; i++) {
          addEvent(el[i], type, fn);
        }
      }
    };
  } else {
    return function (el, type, fn) {
      if (el && el.nodeName || el === window) {
        el.attachEvent('on' + type, function () { return fn.call(el, window.event); });
      } else if (el && el.length) {
        for (var i = 0; i < el.length; i++) {
          addEvent(el[i], type, fn);
        }
      }
    };
  }
})();

(function () {

var pre = document.createElement('pre');
pre.id = "view-source"

// private scope to avoid conflicts with demos
addEvent(window, 'click', function (event) {
  if (event.target.hash == '#view-source') {
    // event.preventDefault();
    if (!document.getElementById('view-source')) {
      // pre.innerHTML = ('<!DOCTYPE html>\n<html>\n' + document.documentElement.innerHTML + '\n</html>').replace(/[<>]/g, function (m) { return {'<':'<','>':'>'}[m]});
      var xhr = new XMLHttpRequest();

      // original source - rather than rendered source
      xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          pre.innerHTML = this.responseText.replace(/[<>]/g, function (m) { return {'<':'<','>':'>'}[m]});
          prettyPrint();
        }
      };

      document.body.appendChild(pre);
      // really need to be sync? - I like to think so
      xhr.open("GET", window.location, true);
      xhr.send();
    }
    document.body.className = 'view-source';
    
    var sourceTimer = setInterval(function () {
      if (window.location.hash != '#view-source') {
        clearInterval(sourceTimer);
        document.body.className = '';
      }
    }, 200);
  }
});
  
})();

//////////////////////////////////////////
//websocket
function openConnection() {
  // uses global 'conn' object
  if (conn.readyState === undefined || conn.readyState > 1) {
	//////////////////////////////////////////////////////
	//重新设置状态
	statusBar.className = 'chat_fail';
	connected.innerHTML='在线:0';
	state.innerHTML = '<img src="image/index/chat_coct.gif"/> 正在连接到聊天室...';
	///////////////////////////////////////////////////////  
    conn = new WebSocket('ws://<?=$wsadr?>:1000'); 
    conn.onopen = function () {
            state.innerHTML = '正在获取信息...';
    };
 
    conn.onmessage = function (event) {
            var message = JSON.parse(event.data);
            switch(message.cmd)
            {
            case 0://获取在线人数,服务器连接上后自动给客户端
                connected.innerHTML = "在线:"+message.online_count;
                statusBar.className = 'chat_success';
                state.innerHTML = '<img src="image/index/chating.gif"/> 正常聊天状态';
                //随机呢称
				if(cookie_username=='')
				 {nickname.value='P'+parseInt(Math.random()*1000);}
				 else
				 {nickname.value=cookie_username;}
            break;
            case 1://来了一个人
                connected.innerHTML = "在线:"+message.online_count;
            break;
            case 2://走了一个人
                connected.innerHTML = "在线:"+message.online_count;
            break;            
            case 3://聊天信息
                log.innerHTML = log.innerHTML+'<li>' + message.msg.replace(/[<>&]/g, function (m) { return entities[m]; }) + '</li>';
                log.scrollTop=log.scrollHeight;
            break;
            }
    };
    
    conn.onclose = function (event) {
      //重新打开
	  openConnection();
    };
  }
}

var connected = document.getElementById('connected'),
    log = document.getElementById('log'),
    chat = document.getElementById('chat'),
	nickname=document.getElementById('nickname'),
    form = chat.form,
    conn = {},
    state = document.getElementById('status'),
	statusBar=document.getElementById('statusBar'),
    entities = {
      '<' : '<',
      '>' : '>',
      '&' : '&'
    };
 
if (window.WebSocket === undefined) {
  state.innerHTML = '<img src="image/index/chat_disb.gif"/> 浏览器版本太低无法启用在线聊天';
  statusBar.className = 'chat_fail';
  nickname.style.display="none";
  chat.style.display="none";
} else {
  state.onclick = function () {
    if (conn.readyState !== 1) {
      conn.close();
      setTimeout(function () {
        openConnection();
      }, 250);
    }
  };
  
  addEvent(frmChat, 'submit', function (event){
	event.preventDefault();								
  });
  
  addEvent(chat, 'keyup', function (event) {
    // if we're connected
    if (event.keyCode==13&&conn.readyState === 1&chat.value!='') {
      if(nickname.value=='')
      {         
         log.innerHTML = log.innerHTML+'<li>输入你的呢称吧!!</li>';
      	 log.scrollTop=log.scrollHeight;
      }
      else
      {
		  var uf=nickname.value+": "+chat.value;
		  var sendbuf={cmd:3,msg:uf};
		  conn.send(JSON.stringify(sendbuf));
		  chat.value = '';
		  
		  //修改COOKIES的名称
		  if(cookie_username!=nickname.value)
		  {
			  setCookie("hzhChatUser",nickname.value);
			  cookie_username=nickname.value;
		  }
      }
    }
  });
	openConnection();  
}
</script>
</body>