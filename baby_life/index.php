<?php
/**************************************

Author:Han.zhihong
remark:
站内小短信模块,包括了三个功能add,delete,浏览

***************************************/
require_once("module/Smarty-3.1.16/libs/Smarty.class.php");
require_once("module/mysql.m.php");
require_once("module/encode.m.php");
require_once("_config.php");

//
$method=$_REQUEST['method'];

//添加记录
if(0==strcmp($method,'add'))
{
	$reback=$_REQUEST['reback'];  //执行完页面后返回的页面
	if(0==strcmp($reback,''))
	{$reback='?';}

    $content=$_REQUEST['c']; 
    $content=zhPhpTrSql($content);
    if(is_null($content))
    {
        echo'content is not null!!';
        exit;
    }
    $db=new PzhMySqlDB();		
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
    $db->query("insert into tb_bb_life(content) value('$content')",0,0);
    $db->close();

    //返回到上一个页面
    header("Location: $reback"); 
    exit;
}

//删除记录
else if(0==strcmp($method,'delete'))
{
    $autoid=$_REQUEST['autoid'];
	$page=$_REQUEST['page'];
    if(is_null($autoid))
    {
        echo'autoid is not null!!';
        exit;
    }
    $db=new PzhMySqlDB();		
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
    $db->query("delete from tb_bb_life where autoid=$autoid",0,0);
    $db->close();
	
	$reback="?page=$page";
	header("Location: $reback"); 
    exit;
}

//method什么参数都没有
else
{
    //每页显示的记录数
    $size=20;
    $page=$_REQUEST['page'];
    if(0==strcmp($page,''))
    { $page=0; }
    
    //获取
    $msgs_ary=array();
    $db=new PzhMySqlDB();		
	$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);
    
    $db->query("select count(autoid) from tb_bb_life",0,0);
    if($rs=$db->read())
    {
      $counts=$rs[0];
      $pages=$counts/$size+1;
    }
    
    $db->query("select * from tb_bb_life order by uptime desc",$size,$page);
    while($rs=$db->read())
    {
      $msgs_ary[]=array(
             'autoid'=>$rs['autoid'],
             'content'=>$rs['content'],
             'uptime'=>$rs['uptime'],
            );
    }
    $db->close();

    //模版页面
    $smarty = new Smarty;
    $smarty->force_compile = smarty_force_compile;
    $smarty->debugging = smarty_debugging;
    $smarty->caching = smarty_caching;
    $smarty->cache_lifetime = smarty_cache_lifetime;
    
    $smarty->assign("msgs_ary",$msgs_ary);
    $smarty->assign("counts",$counts);
    $smarty->assign("pages",$pages);
	$smarty->assign("page",$page);
    $smarty->display('index.tpl');
}

?>