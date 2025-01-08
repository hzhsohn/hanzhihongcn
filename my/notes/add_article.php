<?php
require_once('../_config.php');
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');
require_once("../_module/session.m.php");
require_once("ueedit_encode.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="0;url=../admin/?reback=../notes/add_article.php">';
	echo'no userinfo';
	exit; 
}

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
	//if(get_magic_quotes_gpc())//如果get_magic_quotes_gpc()是打开的
  {
    $conent=stripslashes($conent);//将字符串进行处理
  }

	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	if($db->query("insert into tbnote(ip,typetwo_id,title,content,uptime) values('$ip',$twotype,'$title','$conent',now())"))
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


$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typeone");
while($rs=$db->read()){
		$typeoneID[]=$rs['autoid'];
		$typeoneText[]=$rs['type_text'];
}

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query("select * from typetwo");
while($rs=$db->read()){
	$typetwoID[]=$rs['autoid'];
	$typetwoOneID[]=$rs['typeone_id'];
	$typetwoText[]=$rs['type_text'];
}
$db->close();

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
<script src="./js/trim.js"></script>
<script type="text/javascript" src="./js/ue/ueditor.config.js"></script>
<script type="text/javascript" src="./js/ue/ueditor.all.min.js"></script>
<script type="text/javascript" src="./js/jquery-1.8.2.min.js"></script>
<link href='./js/ue/themes/default/css/ueditor.css' rel="stylesheet" type="text/css" />
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
    <td height="28" align="center" bgcolor="#669900"><span class="STYLE2">文章添加</span></td>
  </tr>
  <tr>
    <td valign="top"><form action="?" method="post" enctype="multipart/form-data" name="form1">
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td  align="center">文章标题：
            <input name="title" type="text" id="title" size="25" maxlength="100" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型：
            <select name="twotype" id="twotype">
              <option value="0">未分类</option>
              <?php
				  	for($i=0;$i<count($typeoneID);$i++)
					{
						echo '<optgroup label="'.$typeoneText[$i].'">';
						for($j=0;$j<count($typetwoID);$j++)
						{
							if($typeoneID[$i]==$typetwoOneID[$j])
							{
								echo '<option value="'.$typetwoID[$j].'">';
								echo $typetwoText[$j];
								echo '</option>';
							}
						}
						echo '</optgroup>';
					}
			  ?>
            </select>
            <input name="method" type="hidden" id="typename" value="add"/></td>
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
