<?php
require_once("../_module/Smarty-3.1.16/libs/Smarty.class.php");
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');
require_once('../_module/session.m.php');
require_once('_config.php');

//ละถฯตวยผตฤSESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if(is_null($userinfo))
{
	echo '<meta http-equiv="refresh" content="5;url=index.php">';
	echo'no userinfo';
	exit; 
}


$result=0;
if(0==strcmp($_REQUEST['method'],'insert'))
{
	    $USERNAME=zhPhpTrSql($_REQUEST['USERNAME']);
		$passwd=$_REQUEST['PASSWORD'];
		$REMARK=zhPhpTrSql($_REQUEST['REMARK']);
		
		$db=new PzhMySqlDB();	
		$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
		$passwd=md5($passwd);
		$passwd=md5($passwd);
		$passwd=substr($passwd,11,20);


		$db->query("select*from admin where username='$USERNAME'",0,0);
		if(!$db->read())
		{
			 $db->query("insert into admin(username,passwd,lastlogin,remark,ip) values('$USERNAME','$passwd',now(),'$REMARK','0.0.0.0')");
			
			 $result=1; 
			
		}else{
			 $result=2;
		}
		$db->close();
}


//ฯิสพาณรๆ
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$smarty->assign('result',$result);

$smarty->display('addadmin.tpl');

   
?>