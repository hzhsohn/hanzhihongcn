<?php
/**************************************

Author:Han.zhihong
remark:
更新坐标信息

***************************************/
require_once('../module/encode.m.php');
require_once('../module/mysql.m.php');
require_once('../_config.php');

date_default_timezone_set('PRC'); //获取系统时间

$version=$_REQUEST['v']; //版本号
$user_id=$_REQUEST['u']; //用户的autoid
$post_coodr_id=$_REQUEST['p']; //设备定位绑定ID
$longitude=$_REQUEST['lo'];  //坐标
$latitude=$_REQUEST['la'];  //坐标
$update_env=$_REQUEST['e']; //硬件提交的是WIFI还是蜂窝网络
 
//判断参数
if($version=='' ||
$user_id==''|| 
$post_coodr_id=='' ||
$longitude=='' || 
$latitude==''||
$update_env=='')
{
	echo '{
	"ret": 1,
	"msg": "no parameter",
	}';
	exit;
}

if(1==$version)
{
    $db=new PzhMySqlDB;
    $db->open_mysql(cfg_db_host,cfg_db_name,cfg_db_username,cfg_db_passwd);
    $user_id=zhPhpTrSql($user_id);
    $post_coodr_id=zhPhpTrSql($post_coodr_id);
    $longitude=zhPhpTrSql($longitude);		
    $latitude=zhPhpTrSql($latitude);

    $sql="call sp_update_coodr($user_id,$post_coodr_id,$longitude,$latitude,$update_env)";
    $db->query($sql);
    $rs=$db->read();
    if(1==$rs[0])
    {
      echo '{
      "ret": 0,
      "msg": "",
      }';
    }
    else
    {
      echo '{
      "ret": 3,
      "msg": "update db fail"
      }';
    }
    $db->close();
}
?>