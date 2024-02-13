<?php

require '_module/Smarty-3.1.16/libs/Smarty.class.php';

$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = true;
$smarty->cache_lifetime = 120;

$ary=array();

$ary[]=array(
"icon"=>"android/anroid_chinachess.gif",
"appname"=>"中国象棋",
"content"=>"中国象棋是由两人轮流走子，以“将死”或“困毙”对方将（帅）为胜的一种棋类运动，有着数以亿计的爱好者。它不仅能丰富文化生活，陶冶情操，更有助于开发智力，启迪思维，锻炼辨证分析能力和培养顽强的意志。<br />
对局时，由执红棋的一方先走，双方轮流各走一着，直至分出胜、负、和，对局即终了。轮到走棋的一方，将某个棋子从一个交叉点走到另一个交叉点，或者吃掉对方的棋子而占领其交叉点，都算走一着。双方各走一着，称为一个回合。<br />
　 象棋是中华民族的传统文化，不仅在国内深受群众喜爱，而且",
"video"=>"",
"apk"=>"http://app.cnmo.com/android/143484/");


$smarty->assign("APP",$ary);
$smarty->display('android.tpl');

?>
