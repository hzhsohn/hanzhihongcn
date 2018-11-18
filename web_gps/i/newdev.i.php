<?php
/**************************************

Author:Han.zhihong
remark:
新设备

***************************************/
require_once("../module/mysql.m.php");
require_once("../module/encode.m.php");
require_once("../_config.php");

//获取参数
$version=$_REQUEST['v']; //版本号
$checksum=$_REQUEST['c']; //能被7整除的校验码
$post_coodr_id=$_REQUEST['p']; //设备定位绑定ID
$remark=$_REQUEST['r']; //设备呢称
$account=$_REQUEST['acc']; //验证的账号
$pwd=$_REQUEST['pwd']; //验证账号的密码

//判断参数
if($version=='' ||
$checksum==''|| 
$post_coodr_id=='' ||
$remark=='' ||
$account=='' ||
$pwd=='')
{
	echo '{
	"ret": 1,
	"msg": "no parameter",
	}';
	exit;
}

if(0!=$checksum%7)
{
  echo '{
	"ret": 2,
	"msg": "checksum error",
	}';
  exit;
}

//------------------------------------------
if(1==$version)
{
    $db=new PzhMySqlDB;
    $db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
    $account=zhPhpTrSql($account);
    $pwd=md5($pwd);
    $pwd=md5($pwd);
    $post_coodr_id=zhPhpTrSql($post_coodr_id);
    
    $sql="call sp_add_newdev('$post_coodr_id','$remark','$account','$pwd')";
    $db->query($sql);
    $rs=$db->read();
    if(1==$rs[0])
    {
      echo '{
"ret": 0,
"msg": "",
"user_id":"'.$rs['autoid_'].'",
"post_coodr_id":"'.$post_coodr_id.'"
}';
    }
    else if(2==$rs[0])
    {
      echo '{
"ret": 3,
"msg": "repeat dev_post_id fail"
}';
    }
    else if(3==$rs[0])
    {
      echo '{
"ret": 4,
"msg": "not enough place"
}';
    }
    else if(4==$rs[0])
    {
      echo '{
"ret": 5,
"msg": "account or password fail"
}';
    }
    $db->close();
}

?>