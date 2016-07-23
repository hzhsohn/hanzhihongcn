<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/left.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #0000FF;
}
a:visited {
	text-decoration: none;
	color: #0000FF;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
}
-->
</style>
<title><?=$SITE_TITLE?>后台管理系统</title><head>
<script src="js/prototype.lite.js" type="text/javascript"></script>
<script src="js/moo.fx.js" type="text/javascript"></script>
<script src="js/moo.fx.pack.js" type="text/javascript"></script>
<body>
	<div id="container">
<H1 class="title"><A href="javascript:void(0)">消息管理</a></H1>
		<div class="content">
			<p><a href="_news/list.php" target="iframeRightBottom">消息发布</a></p>
			<p><a href="_product/list.php" target="iframeRightBottom">产品发布</a></p>
			<br>
		</div>
		<H1 class="title"><A href="javascript:void(0)">用户帮助</a></H1>
	  <div class="content">
        	<p><a href="_freeback/list_freeback.php" target="iframeRightBottom">用户反馈</a></p>
            <p><a href="_question/list_question.php" target="iframeRightBottom">常见问题</a></p>
			<br>
		</div>
<H1 class="title"><A href="javascript:void(0)">管理员设置</a></H1>
		<div class="content">			
			<p><a href="_admin/adminlist.php" target="iframeRightBottom">管理员列表</a></p>	
			<p><a href="_admin/addadmin.php" target="iframeRightBottom">添加管理员</a></p>
			<p><a href="_admin/adminpassword.edit.php" target="iframeRightBottom">修改管理员密码</a></p>	
			<br>	
		</div>

</div>
	<p>&nbsp;</p>
</body>
	<script type="text/javascript">
		var contents = document.getElementsByClassName('content');
		var toggles = document.getElementsByClassName('title');	
		var myAccordion = new fx.Accordion(
			toggles, contents, {opacity: true, duration: 400}
		);
		myAccordion.showThisHideOpen(contents[0]);		
	</script>
