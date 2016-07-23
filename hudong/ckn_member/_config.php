<?php
/**************************************

Author:Han.zhihong
remark:
此文件用于配置member模块的PHP公共变量内容

***************************************/

require_once("_userinfo.php");

//-email发送的信息------------------------------
define('email_server','smtp.163.com');      // SMTP服务器
define('email_port','25');                        // SMTP端口
define('email_fromemail','sohn@163.com');    // from邮箱账号，填写您的邮箱账号
define('email_frompassword','asdffdsa');     // from邮箱密码，填写您的邮箱密

//激活邮件信息
define('email_action_key','HI-k3*1Po');       //邮件激活的加密钥匙
define('email_action_url','http://www.cloudkon.com/member/action_page.php');  //激活页面存放的URL地址

//修改密码邮件信息
define('email_reset_passwd_key','03cjH*j-r'); //修改密码的钥匙
define('email_reset_passwd_url','http://www.cloudkon.com/member/forgot_page.php');  //重置密码存放的URL地址

//-数据库信息------------------------------
//用户数据库
define('cfg_accountdb_host','192.168.2.1');
define('cfg_accountdb_username','root');
define('cfg_accountdb_passwd','Dd123');
define('cfg_accountdb','account_db');
//成员数据库
define('cfg_memberdb_host','192.168.2.1');
define('cfg_memberdb_username','root');
define('cfg_memberdb_passwd','Dd123'); 
define('cfg_memberdb','ckn_member');

//-smarty模板库的参数------------------------------
define('smarty_force_compile',false);
define('smarty_debugging',false);
define('smarty_caching',false);
define('smarty_cache_lifetime',120);

/*
普通用户的基础功能模块ID

每个功能信息都包括几部分,组成一个数组
1.一维元素KEY-----整个功能组的GUID,不同功能要使用不同的GUID,数组索引也是GUID,string类型
2.二维元素[folder]----service目录下的子目录名称,功能单元以整个目录划分,string类型
3.二维元素[title]----显示名称,string类型
4.二维元素[remark]----备注内容,string类型
5.二维元素[subtype]----元素的子分类
*/
$cfg_member_service=array(
  /*
    '{C9978D2D-2739-E4D4-7B8B-3A4203363D24}'=>array(
                  'folder'=>'admin_active', 
                  'title'=>'管理员角色提权', 
                  'remark'=>'将用户提权到管理员',
                  'subtype'=>0), 
  */
);


/*
判断管理员功能单元是否有权限操作相关的GUID
return ture 或 false

sample:
--------------------------------------------
if(false==checkMemberUnit($userinfo,'{C9978D2D-2738-E4D4-7B8B-3A4203363D24}'))
{
  echo 'you are no permission.!';
  exit;
}
---------------------------------------------
*/
function checkMemberUnit($uinfo,$guid)
{
  $b=false;
  foreach($uinfo->ary_member_unit as $unit)
  {
    if(0==strcmp($unit,$guid))
    {
      $b=true;
      break;
    }
  }
  return $b;
}

?>