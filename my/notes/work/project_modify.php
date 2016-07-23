<?php

require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');
require_once("../../_module/session.m.php");

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="0;url=../../admin/?reback=../notes/work">';
	echo'no userinfo';
	exit; 
}

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$autoid=$_REQUEST['autoid'];
if(0==strcmp($autoid,''))
{
	echo 'no autoid';
	exit;	
}

$method=$_REQUEST['method'];
if(0==strcmp($method,'update'))
{
	$set_name=$_REQUEST['set_name'];
	$set_name=zhPhpTrSql($set_name);
	if(0==strcmp($set_name,''))
	{
		echo 'err="负责人不能为空"';
		exit;
	}
	
	$check_name=$_REQUEST['check_name'];
	$check_name=zhPhpTrSql($check_name);
	if(0==strcmp($check_name,''))
	{
		echo 'err="监督不能为空"';
		exit;
	}
	
	//
	$content=$_REQUEST['content'];
	$content=zhPhpTrSql($content);
	if(0==strcmp($content,''))
	{
		echo 'err="项目内容不能为空"';
		exit;
	}
	
	//git地址
	$gitadr=$_REQUEST['gitadr'];
	$gitadr=zhPhpTrSql($gitadr);
	
	$ip=$_SERVER['REMOTE_ADDR'];

	$sql="update work_list set ip='$ip',set_name='$set_name',check_name='$check_name',content='$content',git_adr='$gitadr' where autoid=$autoid";

	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	if($db->query($sql,0,0))
	{
		echo '记录修改成功';	
	}
	else
	{
		echo '操作失败';	
	}
	echo '<p><a href=?autoid='.$autoid.'>查看</a></p>';
	$db->close();
	exit;
}


$sql="select*from work_list where autoid=$autoid";

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
$db->query($sql,0,0);	
if($rs=$db->read())
{
	$autoid=$rs['autoid'];
	$set_name=$rs['set_name'];
	$check_name=$rs['check_name'];
	$content=$rs['content'];
	$time=$rs['time'];
	$gitadr=$rs['git_adr'];
}
?>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
body {
	background-color: #E0E0E0;
}
-->
</style>
<body>
<p>&nbsp;</p>
<form name="form1" method="post" action="?method=update"><table width="98%" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>修改项目信息</strong></td>
    </tr>
  <tr>
    <td width="20%" bgcolor="#FFFFFF">项目开始日期</td>
    <td bgcolor="#FFFFFF"><?php $dtime=$time;
	$dtime=explode(" ",$time);
	echo $dtime=$dtime[0];
	?></td>
  </tr>
  <tr>
    <td  bgcolor="#FFFFFF">负责人</td>
    <td bgcolor="#FFFFFF"><input name="set_name" type="text" id="set_name" value="<?php echo $set_name; ?>" AUTOCOMPLETE="off">
      *不能为空</td>
  </tr>
  <tr>
      <td bgcolor="#FFFFFF">监督</td> <td width="89%" bgcolor="#FFFFFF"><input name="check_name" type="text" id="check_name" value="<?php echo $check_name; ?>" AUTOCOMPLETE="off">
  *不能为空</td>
	  </tr><tr>
	    <td bgcolor="#FFFFFF">项目内容</td> <td bgcolor="#FFFFFF"><textarea name="content" id="content" cols="50" rows="8"><?php echo $content; ?></textarea>
	    *不能为空</td>
		</tr><tr>
		  <td bgcolor="#FFFFFF">git地址</td><td bgcolor="#FFFFFF"><p>
          	%ip -- 将字符转换成网站地址输出,例如: &quot;我的IP是%ip&quot;
		    </p>
		    <p>
		      <input name="gitadr" type="text" id="gitadr" value="<?php echo $gitadr?>" size="50" >
	        </p></td>
		</tr>
		<tr>
		  <td height="59" colspan="2" bgcolor="#FFFFFF">&nbsp;<input type="submit" name="button2" id="button2" value="  提交  ">
	      <input name="autoid" type="hidden" id="autoid" value="<?php echo $autoid?>"></td>
    </tr>
</table></form>

</body>

<?php $db->close(); ?>
