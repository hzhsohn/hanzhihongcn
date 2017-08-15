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
<meta name="image" content="http://www.hanzhihong.cn/image/index/hzh_logo.png">
<title>Han.zhihong Blog</title>
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="../FlashScripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

var searchImg=new Array;
searchImg[0]=new Image;
searchImg[1]=new Image;
searchImg[0].src='image/index/menu_search_1.png';
searchImg[1].src='image/index/menu_search_0.png';
var searchUrlImg0='url('+searchImg[0].src+')';
var searchUrlImg1='url('+searchImg[1].src+')';
//-->
</script>

</head>
<body onload="MM_preloadImages('image/index/menu1_1.png');">
<div id="divContent">
  <div id="divTitle">
    <div id="title_Logo"></div>
    <div id="title_Menu">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr><script>document.getElementById("t"+"e"+"s"+"i").style.display='none';</script>
          <td><a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Menu_1','','image/index/menu1_1.png',1)"><img src="image/index/menu1_0.png" alt="主页" name="Menu_1" border="0" id="Menu_1" /></a></td>
          <td><form name="frmSearch" id="frmSearch" method="get" action="" >
                <input type="text" name="q" id="menuSearch" onfocus="this.style.backgroundColor='#FFF';frmSearch.style.backgroundImage=searchUrlImg0;" onblur="this.style.backgroundColor='#5e5e5e';frmSearch.style.backgroundImage=searchUrlImg1;"/>
          </form></td>
        </tr>
      </table>
    </div>
  </div>
  <div id="divMid" align="center">
      <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="510" height="400">
        <param name="movie" value="music.swf" />
        <param name="quality" value="high" />
        <param name="wmode" value="opaque" />
        <param name="swfversion" value="8.0.35.0" />
        <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
        <param name="expressinstall" value="../FlashScripts/expressInstall.swf" />
        <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
        <!--[if !IE]>-->
        <object type="application/x-shockwave-flash" data="music.swf" width="510" height="400">
          <!--<![endif]-->
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="8.0.35.0" />
          <param name="expressinstall" value="../FlashScripts/expressInstall.swf" />
          <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
          <div>
            <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
          </div>
          <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
      </object>
  </div>
  <div id="divFooter">
    <div id="divCopyright">Copyright@2012  , Design By Han.zh , 粤ICP备13015372号</div>
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
swfobject.registerObject("FlashID");
</script>
</body>