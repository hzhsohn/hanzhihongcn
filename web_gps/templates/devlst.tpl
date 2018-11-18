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
#mid #nav2 #form1 {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
#mid #left {
	width: 22%;
	margin-right: auto;
	border-right-style: solid;
	border-right-width: 2px;
	border-right-color: #690;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	height: 400px;
}
#mid #nav2 #form1 p {
	color: #F00;
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
#logobar #title #logo {
	width: 22%;
}
#logobar #title #nav {
	width: 76%;
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

.andtext a:link {
	color:#F60;
	TEXT-DECORATION: none;
	font-weight: bold;
}

.andtext a:hover {
	COLOR: #36F;
	text-decoration: underline;
}

-->
</style>

<script src="js/base64.js"></script>
<script language="javascript">

function MM_goToURL() 
{ //v3.0
    var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
    for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function del(aid)
{
	if(confirm("是否要删除?"))
	MM_goToURL('self','?exc=del&p0='+{$userid}+'&p1='+aid);
}
function alter(aid,text)
{
	var base64 = new Base64();  
	text=base64.encode(encodeURIComponent(text));
	MM_goToURL('self','?exc=alter&p0='+{$userid}+'&p1='+aid+'&p2='+text);
	base64=NULL;
}
</script>
</head>
<body bgcolor="#F8F8F8">
<div id="navigation">&nbsp;</div>
{include file="pub_top.tpl"}
<div id="mid">
<div>
<strong>定位列表管理</strong>
<div>
  <p><a href="index.php">主页</a></p>
</div>
  <hr />
    <div>
    <p>
    {if 1==$saveok}
    <font color="#FF3300"><strong>*修改成功</strong></font>
    {else if 2==$saveok}
    <font color="#FF3300"><strong>*删除成功</strong></font>
    {/if}
    </p>
      {if $ary_device_count>0}
      <form name="form1" id="form1" action="" method="post">
      
  <table width="100%" border="1" cellspacing="0" cellpadding="8">
  <tr>
    <td bgcolor="#BBBBBB"><strong>定位ID</strong></td>
    <td align="center" bgcolor="#BBBBBB"><strong>呢称</strong></td>
    <td colspan="2" align="center" bgcolor="#BBBBBB"><strong>操作</strong></td>
    </tr>
{section name=devlst loop=$ary_device}
  <tr>
    <td bgcolor="#EEEEEE">{$ary_device[devlst].post_coodr_id}</td>
    <td bgcolor="#EEEEEE"><input name="t{$ary_device[devlst].autoid}" id="t{$ary_device[devlst].autoid}" value="{$ary_device[devlst].remark}" style="
    width:99%"/> </td>
    <td align="center" bgcolor="#EEEEEE"><a href="javascript:del({$ary_device[devlst].autoid})">删除</a></td>
    <td align="center" bgcolor="#EEEEEE"><a href="javascript:alter({$ary_device[devlst].autoid},form1.t{$ary_device[devlst].autoid}.value)">修改</a></td>
  </tr>
{/section}
</table>

      </form>  
      {else}
      <div align="center">
        <p>你还没有任何定位设备</p>
        <p><strong><a href="newdev.php">我要添加定位</a></strong></span>
        {/if}
        </div>
      </div>
  </div>
<br class="clearfloat" />
</div>
<div id="footer">{#copyright#}</div>
</body>
</html>