<?php

require_once('../config.php');
require_once('../../_module/mysql.m.php');
require_once('../../_module/encode.m.php');

//1.html   2.add   3.modify
$method=$_REQUEST['method'];

$work_list_autoid=$_REQUEST['wlist_id'];
if(intval($work_list_autoid)<=0)
{
	echo 'err="wlist_id is null"';
	exit;
}


/////////////////////////////////////////////
//添加
if(0==strcmp($method,'add'))
{
	//$confirm 授权人
	$confirm=$_REQUEST['confirm'];
	$confirm=zhPhpTrSql($confirm);
	if(0==strcmp($confirm,''))
	{
		echo 'err="confirm is null"';
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

	$ip=$_SERVER['REMOTE_ADDR'];

	$sql='insert into work_log(ip,work_list_autoid,content,confirm,time) values(\''.$ip.'\',\''.$work_list_autoid.'\',\''.$content.'\',\''.$confirm.'\',now())';
	
	$db=new PzhMySqlDB();	
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
	if($db->query($sql,0,0))
	{
		echo 'operator success.';	
	}
	$db->close();
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<form name="form1" method="post" action="?method=add"><table width="100%" border="0">
<tr>
  <td>操作员</td> <td><input type="text" name="confirm" id="confirm" AUTOCOMPLETE="off"></td>
</tr><tr><td>内容</td><td><textarea name="content" id="content" cols="45" rows="5"></textarea></td>
</tr><tr><td></td><td><input type="submit" name="button2" id="button2" value="提交"></td>
</tr></table><input type="hidden" name="wlist_id" id="wlist_id" value="<?=$work_list_autoid?>"/></form>