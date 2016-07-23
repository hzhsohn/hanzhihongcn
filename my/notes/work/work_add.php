<?php

require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');

//1.html
$method=$_REQUEST['method'];

if(0==strcmp($method,'add'))
{
	//$set_name 负责人
	$set_name=$_REQUEST['set_name'];
	$set_name=zhPhpTrSql($set_name);
	if(0==strcmp($set_name,''))
	{
		echo 'err="set_name is null"';
		exit;
	}
	//$set_name 审核人
	$check_name=$_REQUEST['check_name'];
	$check_name=zhPhpTrSql($check_name);
	if(0==strcmp($check_name,''))
	{
		echo 'err="check_name is null"';
		exit;
	}

	//$content 工作内容
	$content=$_REQUEST['content'];
	$content=zhPhpTrSql($content);
	if(0==strcmp($content,''))
	{
		echo 'err="content is null"';
		exit;
	}
	
	$gitadr=$_REQUEST['gitadr'];
	$gitadr=zhPhpTrSql($gitadr);

	$ip=$_SERVER['REMOTE_ADDR'];

	$sql='insert into work_list(ip,set_name,check_name,schedule,content,time,git_adr) values(\''.$ip.'\',\''.$set_name.'\',\''.$check_name.'\',0,\''.$content.'\',now(),\''.$gitadr.'\')';

	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	if($db->query($sql,0,0))
	{
		echo 'operator success <a href="?">Done</a>';	
	}
	else
	{
		echo 'operator <a href="?">fail</a>';
	}
	$db->close();
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<style type="text/css">
<!--
.title {
	font-size: 24px;
	color: #600;
	font-weight: bold;
	text-align: center;
	margin-bottom: 15px;
}
body {
	background-color: #CCC;
}
-->
            </style>
<form name="form1" method="post" action="?method=add"><table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
		  <td colspan="2" bgcolor="#FFFFFF"><div class="title">添加新项目</div></td>
		  </tr>
		<tr>
		  <td width="20%" bgcolor="#FFFFFF">负责人</td><td bgcolor="#FFFFFF"><input type="text" name="set_name" id="set_name" AUTOCOMPLETE="off"></td>
		</tr><tr><td bgcolor="#FFFFFF">监督</td> <td bgcolor="#FFFFFF"><input type="text" name="check_name" id="check_name" AUTOCOMPLETE="off"></td>
		</tr><tr>
		  <td bgcolor="#FFFFFF">工作内容</td><td bgcolor="#FFFFFF"><textarea name="content" id="content" cols="50" rows="10"></textarea></td>
		</tr>
		<tr>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
		<tr>
		  <td bgcolor="#FFFFFF">git地址</td>
		  <td bgcolor="#FFFFFF"><p>
          	%ip -- 将字符转换成网站地址输出,例如: &quot;我的IP是%ip&quot;
		    </p>
		    <p>
		      <input name="gitadr" type="text" id="gitadr" value="git clone dev@%ip:???" size="50" >
	        </p></td>
    </tr>
		<tr>
		  <td align="right" bgcolor="#FFFFFF">&nbsp;</td><td align="center" bgcolor="#FFFFFF"><a href="work_list.php">
		    <input type="submit" name="button2" id="button2" value="提交" />
		  </a></td>
	    </tr>
</table></form>