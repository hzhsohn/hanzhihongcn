<?php
require_once('../public/encode.m.php');
require_once('../public/mysql.m.php');
require_once('../public/redirect.m.php');
require_once('../public/session.m.php');
require_once('../public/_config.php');
require_once('../public/folder.m.php');
require_once("ueedit_encode.php");

$method=$_REQUEST['method'];
if(0==strcmp($method,'add'))
{
	$title=trim($_REQUEST['title']);
	$conent=$_REQUEST['con'];
	$twotype=$_REQUEST['twotype'];
	if(0==strcmp($twotype,''))
	{$twotype=0;}

	$title=zhPhpTrSql($title);
	$ip=$_SERVER['REMOTE_ADDR'];
	
	$conent=ueTrSql($conent);//将字符串进行处理
	if(get_magic_quotes_gpc())//如果get_magic_quotes_gpc()是打开的
  {
    $conent=stripslashes($conent);//将字符串进行处理
  }

	$db=new PzhMySqlDB();
	$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
	//上传
	set_time_limit(0);
	$ttName='';
	if(isset($_FILES['uploadinput']))
	{
		$path='upload_titleimg';
		zhPhpMkDir($path);
		if(strcmp($_FILES['uploadinput']['name'],'') )
		{			
			$fileName=create_guid().urlencode($_FILES['uploadinput']['name']);
			$ttName=$path.'/'.$fileName;
			move_uploaded_file($_FILES['uploadinput']['tmp_name'],$ttName);
		}
	}
	if($db->query("insert into tbProduct(ip,title,remark,titleimg) values('$ip','$title','$conent','$ttName')"))
	{
		//$db->query("select @@identity");
		echo "添加成功...";
	}
	else
	{
		echo "------- 操作失败 --------";
	}
	$db->close();
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
.STYLE1 {
	font-size: 12px;
	color: #FF0000;
}
body,td,th {
	font-size: 12px;
}
.STYLE2 {
	font-size: 24px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script src="../js/trim.js"></script>
<script type="text/javascript" src="../js/ue/ueditor.config.js"></script>
<script type="text/javascript" src="../js/ue/ueditor.all.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<link href='../js/ue/themes/default/css/ueditor.css' rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCC;
}
-->
</style></head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="background-color:#f5f6fa">
  <tr>
    <td height="28" align="center" bgcolor="#669900"><span class="STYLE2">添加文章</span></td>
  </tr>
  <tr>
    <td valign="top"><form action="?" method="post" enctype="multipart/form-data" name="form1">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td  align="center">标题：
            <input name="title" ty
            pe="text" id="title" size="25" maxlength="100" />
            <input name="method" type="hidden" id="typename" value="add"/></td>
        </tr>
        <tr>
          <td  align="center">标题图片: 
            <input name="uploadinput" type="file" />
    <input type="hidden" name="MAX_FILE_SIZE" value="4000000000"></td>
          </tr>
       <tr>
         <td align="center" valign="top">
         <script id="con" name="con" type="text/plain"></script>
        <script type="text/javascript">
          var editor = UE.getEditor('con');
        </script>
         </td>
         </tr>
        <tr>
          <td align="center">
            <script>
		  function sendok()
				{
				if(trim(form1.title.value)==""){
					alert('请填写标题');
				}else if(form1.typename.value==""){
				  alert("请选择文章类型");
				}else{
				 	form1.submit();
				 }
				}
		  </script><br /><input type="button" name="Submit" onclick="sendok()" value=" 提交 "></td>
          </tr>
      </table>
    </form>    </td>
  </tr>
</table>
</body>
