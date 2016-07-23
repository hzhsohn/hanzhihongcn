<?php
require_once('public/redirect.m.php');
require_once('public/session.m.php');
require_once('public/_config.php');

$ADMIN_INFO=zhPhpSessionGet("ADMIN_INFO");
if(NULL==$ADMIN_INFO)
zhPhpRedirect("login.php");

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>
</head>
<script language="javascript">
	function HideMenu()
		{
			var tmpsrc;
			if (document.all["tdLeft"].style.display=="none")
			{
				document.all["tdLeft"].style.display="";
				document.all["BtnHide"].title="收起左侧菜单";
			}
			else
			{
				document.all["tdLeft"].style.display="none";
				document.all["BtnHide"].title="展开左侧菜单";
			}	
			if (document.all["BtnHide"].style.cursor=="e-resize")
			{		
				document.all["BtnHide"].style.cursor="w-resize";
			} 
			else
			{		
				document.all["BtnHide"].style.cursor="e-resize";
			}
			tmpsrc=document.all["BtnHideImg"].src;		
			if (tmpsrc.substring(tmpsrc.length-18,tmpsrc.length)=="/images/img_02.gif")
			{
				document.all["BtnHideImg"].src="images/img_03.gif" 
			}
			else
			{
				document.all["BtnHideImg"].src="images/img_02.gif"
			}
		}
		var	Browser	=	{
			IE			:	!!(window.attachEvent && !window.opera),
			Opera		:	!!window.opera,
			WebKit		:	navigator.userAgent.indexOf('AppleWebKit/') > -1,
			Gecko		:	navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1,
			MobileSafari:	!!navigator.userAgent.match(/Apple.*Mobile.*Safari/)
		};
		function init()
		{
			var objBottom	=	document.getElementById( "bottom" );
			var objTbmain	=	document.getElementById( "tbMain" );
			
			objTbmain.style.height	=	objBottom.offsetTop + objBottom.offsetHeight + "px";
		}
	</script>
	<body style="margin:0;overflow:visible;" onLoad="setTimeout('init()',300)" onResize="init()" onbeforeunload="">
			<table border="0" id="tbMain" style="width:100%; height:593px;" cellspacing="0" cellpadding="0" align="center">	
				<tr>
					<td colspan="3" style="height:70px;">
						<iframe scrolling="no" height="0" marginheight="0" marginwidth="0" style="WIDTH:100%; HEIGHT: 100%;margin:0" noresize src="top.php" FRAMEBORDER="0" name="iframeTop" id="iframeTop" ></iframe>
					</td>
				</tr>
				<tr style="height:100%;">
					<td id="tdLeft" valign="top" style="width:165px;;height:100%;">
						<iframe name="iframeLeft" frameborder="0" style="width:165px; height:100%;margin:0" id="iframeLeft"
							src="left.php"></iframe>
					</td>
					<td style="width:10px;height:100%" id="BtnHide" onClick="HideMenu()" background="images/img_01.gif" title="收起左侧菜单"><img src="images/img_02.gif" id="BtnHideImg"></td>
					<td valign="top" >
					<iframe style="margin:0" width="100%" height="100%" name="iframeRightBottom" id="iframeRightBottom" frameborder="0" src="main.php" id="iframeRightBottom"></iframe>
					</td>
				</tr>
			</table>
			<div id="bottom" style="position:absolute; bottom:0px"></div>
	</body>
</html>

