<?php

require '_module/Smarty-3.1.16/libs/Smarty.class.php';

$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;

$ary=array();


$ary[]=array(
"icon"=>"ios/ios_camping.gif",
"appname"=>"露营助手",
"content"=>"=================================<br />
功能如下:<br />
<br />
1。手电筒功能在晚上一个不可或缺的工具.<br />
2。罗盘功能,让您出行更精确.<br />
3。查看其当前的坐标位置.<br />
4。短信或E-mail发送您的当前坐标,让朋友随即可见.<br />
5。莫尔斯信号闪烁,让你体验更高的安全水平.<br />
6。定时闪光灯,满足更多的乐趣.<br />
7。电子驱蚊器,让蚊子飞得更远.<br />
<br />
***************** 购买注意: ****************<br />
程序大部功能只适合于iPhone设备,使用iTouch的朋友因设备本身没有闪光灯购买时请注意.谢谢理解<br />
<br />
****************************************",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/monitorq/id533006552?l=zh&amp;ls=1&amp;mt=8");


$ary[]=array(
"icon"=>"ios/monitorq.png",
"appname"=>"远程视频监控",
"content"=>"远程视频监控功能,有地址定位,查看记录,流量统计功能<br /><br />
本软件支持设备<br />
1 ------&gt; 大华数字录像机<br />
2 ------&gt; 大华IPCamera<br />
3 ------&gt; 海康网络硬盘录像机<br />
4 ------&gt; 海康IPCamera<br />
5 ------&gt; Mobotix网络摄像机<br />
6 ------&gt; 佳能VB-C50FSI<br />
7 ------&gt; Mjpg-Streamer协议",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/monitorq/id533006552?l=zh&amp;ls=1&amp;mt=8");


$ary[]=array(
"icon"=>"ios/ios_monitor.gif",
"appname"=>"手机远程监控",
"content"=>"以下是软件支持的设备有: <br />
---1.大华数字录像监控机 <br />
---2.大华IPCamera <br />
---3.mjpg-streamer <br />
---4.mobotix <br />
---5.佳能 VB-C50FSI",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/%E6%89%8B%E6%9C%BA%E8%BF%9C%E7%A8%8B%E7%9B%91%E6%8E%A7/id555248523?mt=8");


$ary[]=array(
"icon"=>"ios/ble.png",
"appname"=>"蓝牙串口助手",
"content"=>"蓝牙串口助手,用于调试蓝牙转串口透传模块使用.属于硬件调试工具.",
"video"=>"http://v.youku.com/v_show/id_XODEyMjk1NTMy.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/cn/app/%E8%93%9D%E7%89%99%E4%B8%B2%E5%8F%A3%E5%8A%A9%E6%89%8B/id929959415?mt=8");


$ary[]=array(
"icon"=>"ios/qr.png",
"appname"=>"扫得快(二维码)",
"content"=>"二维码很可爱,简简单单扫得快",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/%E6%89%AB%E5%BE%97%E5%BF%AB-%E4%BA%8C%E7%BB%B4%E7%A0%81/id1043427864?mt=8");



$ary[]=array(
"icon"=>"ios/shq.png",
"appname"=>"洒水器控制器",
"content"=>"洒水器系统控制程序.",
"video"=>"http://v.youku.com/v_show/id_XMTYxODQ4MjA3Ng==.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/cn/app/%E6%B4%92%E6%B0%B4%E5%99%A8%E6%8E%A7%E5%88%B6%E5%99%A8/id1096545636?mt=8");


$ary[]=array(
"icon"=>"ios/deson.png",
"appname"=>"Deson",
"content"=>"德尚公司展未用的灯光控制APP",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/deson/id1148395310?mt=8");


$ary[]=array(
"icon"=>"ios/cb-acoustic.png",
"appname"=>"CB-Acoustic控制",
"content"=>"D6系列康双音响功放控制IPAD版",
"video"=>"http://v.youku.com/v_show/id_XNjExOTYyNDQ4.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"");


$ary[]=array(
"icon"=>"ios/k-cinema.png",
"appname"=>"K-Cinema",
"content"=>"K-Cinema慧响公司是一款卡拉OK前级音频处理器无线控制管理软件，有两个版本，分别是支持Iphone(简易版)和Ipad(专业版)",
"video"=>"http://v.youku.com/v_show/id_XNjExOTYyNDQ4.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/cn/app/k-cinema/id892406513?mt=8");


$ary[]=array(
"icon"=>"ios/jrltd.png",
"appname"=>"璟睿智能",
"content"=>"IPMC810云智能电源管理器，是基于物联网技术，专为影音系统研发的高性能电源管理系统。可根据各类影音系统应用需求，通过其强大的通道延时管理、模式管理和定时管理功能；有效地管理影音设备，彻底解决了影音器材由于人为操作失误而造成的损坏，同时又可杜绝影音设备不合理的开/关时序导致各个设备间的信道识别紊乱；为影音系统提供安全、可靠的保护。<br />
IPMC810具备强大的系统组合能力，采用先进的iCAN分布式总线架构，系统分成16个类别，单类别64台设备容量，多类别积木式组合应用。通过网线级联，实现灯光照明控制、投影机控制、投影幕控制、电动窗帘控制、影音设备控制、触摸墙面板控制、显示触摸屏控制、环境监测、情景切换等诸多功能。极大的规范了影音智能化管理，为用户提供简单、快捷的使用体验。<br />
IPMC810自带无线网关，通过APP简单配置即可实现局域网现场调试管理和广域网远程控制，为现场施工和后期维护提供极佳的便利性，同时提升终端用户的使用体验，展现商家特有的商业价值。",
"video"=>"http://v.youku.com/v_show/id_XMjg3Njk5ODQ5Mg==.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/us/app/%E7%92%9F%E7%9D%BF%E6%99%BA%E8%83%BD/id1208545021?l=zh&ls=1&mt=8");


$ary[]=array(
"icon"=>"ios/st808.png",
"appname"=>"ST-808",
"content"=>"ST-808云智能电源管理器，是基于物联网技术，专为影音系统研发的高性能电源管理系统。可根据各类影音系统应用需求，通过其强大的通道延时管理、模式管理和定时管理功能，有效地管理影音设备，彻底解决了影音器材由于人为操作失误而造成的损坏，同时又可杜绝影音设备不合理的开/关时序导致各个设备间的信道识别紊乱，为用户提供简单、快捷的使用体验。<br />
ST-808具备强大的系统组合能力，采用先进的iCAN分布式总线架构，实现多达64台设备级联使用，通过6类网线手拉手级联，实现多区域同步控制的智能化管理，极大实现项目可行性，提升项目品质，为用户创造极简的使用方式。<br />
ST-808自带无线网关，通过APP简单配置即可实现局域网现场调试管理和广域网远程控制，为现场施工和后期维护提供极佳的便利性，同时提升终端用户的使用体验，展现商家特有的商业价值。<br />
ST-808其性能卓越，使用简单，是音响工程、智能教学系统、智能会议系统、高端会所、广电系统、展厅及品牌店等项目及其它电气工程必不可少的关键元素。",
"video"=>"",
"appstore"=>"https://itunes.apple.com/cn/app/st-808/id1262685617?mt=8");


$ary[]=array(
"icon"=>"ios/bxzn.png",
"appname"=>"柏迩智能",
"content"=>"柏迩智能电源管理APP",
"video"=>"http://v.youku.com/v_show/id_XMzAwMjIxMDkwNA==.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/us/app/%E6%9F%8F%E8%BF%A9%E6%99%BA%E8%83%BD/id1271055738?l=zh&ls=1&mt=8");


$ary[]=array(
"icon"=>"ios/hxkong.png",
"appname"=>"云集成",
"content"=>"功能:<br />
局域网及互联网控制硬件<br />
视频监控<br />
网络调试工具<br /><br />
打造一个方便简易的工具",
"video"=>"http://v.youku.com/v_show/id_XMjg3NjE3MzAzMg==.html?spm=a2h3j.8428770.3416059.1",
"appstore"=>"https://itunes.apple.com/cn/app/%E4%BA%91%E9%9B%86%E6%88%90/id1187178234?l=zh&ls=1&mt=8");


$smarty->assign("APP",$ary);
$smarty->display('ios.tpl');

?>