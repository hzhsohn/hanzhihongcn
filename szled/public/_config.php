<?php
/**************************************

Author:Han.zhihong
remark:
此文件用于配置整个模块的PHP公共变量内容

***************************************/

//-数据库信息------------------------------
//用户数据库
define('cfg_db_host','127.0.0.1');
define('cfg_db_username','root');
define('cfg_db_passwd','Dd123');
define('cfg_db_name','szledfangan');

//-smarty模板库的参数------------------------------
define('smarty_force_compile',false);
define('smarty_debugging',false);
define('smarty_caching',false);
define('smarty_cache_lifetime',120);



function create_guid() {
 $charid = strtoupper(md5(uniqid(mt_rand(), true)));
 $hyphen = chr(45);// "-"
 $uuid = chr(123)// "{"
 .substr($charid, 0, 8).$hyphen
 .substr($charid, 8, 4).$hyphen
 .substr($charid,12, 4).$hyphen
 .substr($charid,16, 4).$hyphen
 .substr($charid,20,12)
 .chr(125);// "}"
 return $uuid;
}

?>