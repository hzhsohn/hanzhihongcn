<?php

//echo PHP_VERSION;
if(PHP_VERSION>6)
{
require_once("_module/smarty-4.3.0/libs/Smarty.class.php");
}
else
{
require_once("_module/Smarty-3.1.16/libs/Smarty.class.php");
}

//用户数据库
define('cfg_db_host','127.0.0.1');
define('cfg_db_username','root');
define('cfg_db_passwd','Dd@123456789');
define('cfg_db','hanzhihongcn');

?>