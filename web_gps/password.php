<?php
/**************************************

Author:Han.zhihong
remark:
修改密码的功能

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/verifycode.m.php");
require_once("module/mysql.m.php");
require_once("module/session.m.php");
require_once("module/encode.m.php");
require_once("_config.php");

//获取SESSION的各种值
$ary_info=zhPhpSessionVal('ary_info');

if(is_null($ary_info))
{
echo'no login';
exit; 
}
if(0==strcmp($ary_info['n_autoid'],''))
{
echo'no username';
zhPhpSessionRemove('ary_info');
exit; 
}

//-------------------------------------------------------
$method=$_REQUEST['method'];

//
$result=0;

//修改密码
if(0==strcmp($method,'update'))
{
    $userid=$ary_info['n_autoid'];
	  $oldpassword=$_REQUEST['oldpassword'];
    if(is_null($oldpassword))
    {
        echo'oldpassword is not null!!';
        exit;
    }
    $password=$_REQUEST['password'];
    if(is_null($password))
    {
        echo'password is not null!!';
        exit;
    }
	$password2=$_REQUEST['password2'];
    if(is_null($password))
    {
        echo'password2 is not null!!';
        exit;
    }
	
	if(0==strcmp($oldpassword,'') || 0==strcmp($password,'') || 0==strcmp($password2,''))
	{
		//其中一个密码为空
		$result=5;
	}
	else
	{
					
		if(strcmp($password,$password2))
		{
			//两次密码不相同
			$result=1;	
		}
		else
		{
			//			
      $oldpassword=md5($oldpassword);
      $oldpassword=md5($oldpassword);

      $password=md5($password);
      $password=md5($password);
      
			$db=new PzhMySqlDB();		
			$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
			$db->query("call sp_update_passwd($userid,'$oldpassword','$password')",0,0);
			if($rs=$db->read())
			{
				switch($rs['result_'])
				{
					case 1://密码修改成功
						$result=2;
					break;
					case 2://密码修改失败,旧密码不对
						$result=3;	
					break;
				}
			}
			else
			{
				//数据库信息错误
				$result=4;
			}
			$db->close();
		}
	}
}


//////////////////////////////////////////////////////////////////////
//打开数据库
$db=new PzhMySqlDB();		
$db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
$db->query('call sp_getdev_info('.$ary_info['n_autoid'].')',0,0);
if($rs=$db->read())
{
	//设备列表
	$ary_ev=array('account'=>$rs['account'],
					  'vip_deadline'=>$rs['vip_deadline'],
					  'max_dev'=>$rs['max_dev'],
					  'dev_count'=>$rs['dev_count']);
}

//var_dump($ary_ev);
$max_dev=$ary_ev['max_dev'];
$dev_count=$ary_ev['dev_count'];

$db->close();


//模版页面
$smarty = new Smarty;
$smarty->force_compile = smarty_force_compile;
$smarty->debugging = smarty_debugging;
$smarty->caching = smarty_caching;
$smarty->cache_lifetime = smarty_cache_lifetime;

//常用信息
$smarty->assign("account",$ary_info['sz_account']);
$smarty->assign("userid",$ary_info['n_autoid']);
$smarty->assign("surplus_dev",$max_dev-$dev_count);

//更新结果
$smarty->assign("result",$result);

$smarty->display('password.tpl');

?>