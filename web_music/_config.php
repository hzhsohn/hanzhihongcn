<?php
/**************************************

Author:Han.zhihong
remark:
此文件用于配置member模块的PHP公共变量内容

***************************************/
include_once('_db.php');


//-smarty模板库的参数------------------------------
define('smarty_force_compile',false);
define('smarty_debugging',false);
define('smarty_caching',false);
define('smarty_cache_lifetime',120);


date_default_timezone_set('PRC'); //获取系统时间
define("_now",date("Y-m-d H:i:s",time()));

?>