{config_load file="admin.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
<style type="text/css">
<!--
#navigation {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 18;
	margin-left: auto;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#mid #left {
	width: 22%;
	margin-right: auto;
	border-right-style: solid;
	border-right-width: 2px;
	border-right-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}

#mid {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 25px;
}
#mid #right {
	width: 79%;
	margin-left: auto;
	height: 380px;
}

#mid #nav2 {
	width: 76%;
}

#mid #nav2 .subtype {
	background-color: #DDD;
	width: 100%;
	font-family: Tahoma, Geneva, sans-serif;
	font-weight: normal;
	color: #363;
}

#mid #nav2 .subtype li{
	padding-bottom: 4px;
	border-bottom-width: 1px;
	border-bottom-style: dashed;
	border-bottom-color: #666;
	margin-bottom: 1px;
	padding-top: 5px;
}

#mid nav2 ol {
	color: #111;
	font-weight: normal;
	font-family: Tahoma, Geneva, sans-serif;
}

.fltrt { /* 此类可用来使页面中的元素向右浮动。浮动元素必须位于页面上要与之相邻的元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用来使页面上的元素向左浮动 */
	float: left;
	margin-right: 8px;
}

.fr { /* 此类可用来使页面中的元素向右浮动。浮动元素必须位于页面上要与之相邻的元素之前。 */
	float: right;
	width:39%;
	text-align: right;
	padding-right:10px;
}
.fl { /* 此类可用来使页面上的元素向左浮动 */
	float: left;
	width:56%;
	padding-left:10px;
}

.clearfloat { /* 此类应当放在 div 或 break 元素上，而且该元素应当是完全包含浮动的容器关闭之前的最后一个元素 */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}

#footer {
	width: 100%; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 28px;
	margin-right: auto;
	margin-bottom: 28px;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #090;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #666;
	height: 50px;
	padding-top: 10px;
	text-align: center;
}

#mid a:link {
 color: #000000;
 TEXT-DECORATION: none
}
#mid a:visited {
 COLOR: #000000;
 TEXT-DECORATION: none
}
#mid a:hover {
 COLOR: #ff7f24;
 text-decoration: underline;
}
#mid a:active {
 COLOR: #ff7f24;  
 text-decoration: underline;
}

#mid #left ul li {
	padding-bottom: 6px;
}
#msg #chat ul {
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}

#msg {
	width: 960px; /* 自动边距（与宽度一起）会将页面居中 */
	margin-top: 0px;
	margin-right: auto;
	margin-left: auto;
	border-top-width: 2px;
	border-top-style: solid;
	border-top-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
#logobar #title #logo img {
	padding-top: 10px;
}
#msg #txt_content {
	width: 500px;
	border: 1px solid #666;
}
#msg #chat {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #CCC;
	padding-bottom: 18px;
	padding-top: 18px;
}
#msg #chat ul li {
	padding-bottom: 2px;
	margin-bottom: 2px;
}

#msg a:link {
 color: #000000;
 TEXT-DECORATION: none
}
#msg a:visited {
 COLOR: #000000;
 TEXT-DECORATION: none
}
#msg a:hover {
 COLOR: #ff7f24;
 text-decoration: underline;
}
#msg a:active {
 COLOR: #ff7f24;  
 text-decoration: underline;
}

.js_move{
	background-color:#FFF;
	font-size: 12px;
	height: 18px;
}

#mydev_title{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	color: #FFF;
	text-decoration: none;
	background-color: #868686;
	padding-top: 5px;
	padding-bottom: 2px;
	padding-left: 6px;
	height:18px;
}

#mydev_title a:link {
 color: #FFF;
 TEXT-DECORATION: none
}
#mydev_title a:hover {
 COLOR: #ff7f24;
 text-decoration: underline;
}
#mydev_title a:visited {
 COLOR: #FFF;  
 text-decoration: underline;
}
-->
</style>
</head>

<body bgcolor="#F8F8F8">
<div id="navigation">&nbsp;</div>
{include file="pub_top.tpl"}
<div id="mid">
  <div id="left" class="fltlft">
  {include file="pub_left_nav.tpl"}
  </div>
  <div id="nav2" class="fltrt">
  	<div id="mydev_title" >
   	  <div class="fltlft">我的设备</div>
    	<div class="fltrt"><a href="devlst.php">[管理]</a>&nbsp;&nbsp;</div>
        <br class="clearfloat" />
    </div>
    <div class="fltlft subtype">
    {section name=devlst loop=$ary_device}
      	<li class="js_move">      		
            <span class="fl"><a href="map.php?did={$ary_device[devlst].autoid}" target="mapfrm">{$ary_device[devlst].post_coodr_id} -- {$ary_device[devlst].remark}&nbsp;&nbsp;[查看]</a></span>
      		<span class="fr">最后更新: {$ary_device[devlst].uptime}</span>
		</li>
    {/section}
     <br class="clearfloat" />
    </div>
  </div>
  <br class="clearfloat" />
</div>
<div id="msg">
	<div id="map">
        <h2>地图定位</h2>
        <iframe scrolling="no" name="mapfrm" marginheight="0px" marginwidth="0px" frameborder="1" height="500px" width="100%" /></iframe> 
</div> 
  	<div align="right">^_^</div>
</div>
<div id="footer">{#copyright#}</div>
</body>
</html>