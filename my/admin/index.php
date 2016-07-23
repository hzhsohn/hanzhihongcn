<?php
require_once("../_module/Smarty-3.1.16/libs/Smarty.class.php");
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');
require_once('../_module/session.m.php');
require_once('_config.php');

$reback=$_REQUEST['reback'];
if(0==strcmp($reback,''))
{
	$reback='adminlist.php';
}

//判断登录的SESSION
$userinfo=json_decode($_SESSION['ADMIN_INFO']);
if($userinfo)
{
	 echo "<meta http-equiv=\"refresh\" content=\"0;url=$reback\">";
	 exit;
}


if(0==strcmp($_REQUEST['method'],'login'))
{
          $username=$_REQUEST['username'];
          $passwd=$_REQUEST['passwd'];
		  
		  //保存账号 
		  setcookie('hzhcn_username',$username,time()+3600*24*7,'/');
			  
            
          $db=new PzhMySqlDB();	
		  $db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
          $passwd=md5($passwd);
          $passwd=md5($passwd);
          $passwd=substr($passwd,11,20);

          $username=zhPhpTrSql($username);	  
				
          $db->query("select * from admin where passwd='$passwd' and username='$username'");
          if($rs=$db->read())
          {
				$info=array();
				$info['username']=$rs['username'].'';
				$_SESSION['ADMIN_INFO']=json_encode($info);
				/*
					//判断登录的SESSION
					$userinfo=json_decode($_SESSION['ADMIN_INFO']);
					if(is_null($userinfo))
					{
					echo '<meta http-equiv="refresh" content="5;url=index.php">';
					echo'no userinfo';
					exit; 
				}
				//使用时应该以类的方式,经过json_decode会被解析成类
				$username=$userinfo->username; 
				*/
				
				if($db->query("update admin set lastlogin=now(),ip='".$_SERVER['REMOTE_ADDR']."' where username='".$rs['username']."'"))
				{
					echo "<meta http-equiv=\"refresh\" content=\"0;url=$reback\">";
					exit;
				}
          }
          else
          {
          $err=1;
          }
          $db->close();
}

//显示页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

$hzhcn_username=$_COOKIE['hzhcn_username'];
$smarty->assign('hzhcn_username',$hzhcn_username);
$smarty->assign('err',$err);
$smarty->assign('reback',$reback);
$smarty->display('index.tpl');

?>
