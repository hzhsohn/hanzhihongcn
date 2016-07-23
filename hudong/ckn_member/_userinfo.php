<?php
/*
站点全局的SESSION结构

例子:
//检测SESSION是否为空或者标准格式,这个是名为userinfo的全局SESSION
$userinfo=json_decode(zhPhpSessionVal('userinfo'));
if(is_null($userinfo))
{
echo '<meta http-equiv="refresh" content="5;url=index.php">';
echo'no userinfo';
zhPhpSessionRemove('userinfo');
exit; 
}
if(0==strcmp($userinfo->sz_userid,'')  ||  !$userinfo->is_admin)
{
echo '<meta http-equiv="refresh" content="5;url=index.php">';
echo'no username or not is admin';
zhPhpSessionRemove('userinfo');
exit; 
}
echo zhPhpSessionVal('userinfo');
*/
class PzhUserinfo
{
  var $sz_userid;           //not null
  var $is_admin;				//role=1 -admin
  var $is_developer;			//role=2 -developer 
  var $is_member;				//role=3 -member
};
?>