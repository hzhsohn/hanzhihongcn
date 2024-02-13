<?php

require '_module/Smarty-3.1.16/libs/Smarty.class.php';

$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;

$ary=array();

$ary[]=array(
"icon"=>"win/serial_helper.png",
"appname"=>"串口助手",
"content"=>"一个串口调试工具,可以通讯TCP远程传输数据,也可以扩展多个协议集组件",
"video"=>"",
"exe"=>"./win/serial_helper.zip");

$ary[]=array(
"icon"=>"win/catchscreen.png",
"appname"=>"截图工具",
"content"=>"直接使用或二次开发,<br/>
请对本程序建立\"桌面快捷方式\",<br/>
然后\"点击右键\"快捷方式的\"属性\",在\"目标\"输入以下四个参数,如右图<br/>
\"C:\CatchScreen.exe\" 0 catch.jpg image/jpeg true <br/>
使用软件时请直接点击快捷方式运行
<br/>
详细参数说明请打开软件查看",
"video"=>"",
"exe"=>"./win/catchscreen.zip");

$ary[]=array(
"icon"=>"win/csharp_mp3.png",
"appname"=>"C#写的MP3播放器",
"content"=>"好多年前的东西了，写的时候还在读大学，怀念。。。<br/>
源码在这<br/>
http://www.pudn.com/Download/item/id/509374.html",
"video"=>"",
"exe"=>"./win/csharp_mp3.zip");

$ary[]=array(
"icon"=>"win/audiostudio.png",
"appname"=>"Audio Studio",
"content"=>"这个项目的主角不是我,但是却给我留下了深深的痛,不过项目还是一个很优秀的作品",
"video"=>"",
"exe"=>"./win/AudioStudio.zip");


$smarty->assign("APP",$ary);
$smarty->display('win.tpl');

?>
