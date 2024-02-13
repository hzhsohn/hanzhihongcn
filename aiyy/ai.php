<?php
$txt=$_REQUEST['t'];

	if(strstr($txt,"小芳") || strstr($txt,"小方") || strstr($txt,"小范") || strstr($txt,"房") || strstr($txt,"翻")  || strstr($txt,"方") )
	{
		echo '别叫我,这名字太土了!';
	}
	else if(strstr($txt,"跳舞"))
	{
		echo "跳毛啊跳!";
	}
	else if(strstr($txt,"歌") || strstr($txt,"哥"))
	{
		echo "唱也行,一块钱一首~！一会给我";
	}
	else if(strstr($txt,"没怎么") || strstr($txt,"没什么") || strstr($txt,"没有") || strstr($txt,"么有")  || strstr($txt,"木有")  || strstr($txt,"木乐"))
	{
		echo "你逗我吗？";
	}
	else if(strstr($txt,"你好") || strstr($txt,"您好"))
	{
		echo "你好!";
	}
	else if(strstr($txt,"我爱你"))
	{
		echo "不要爱我";
	}
	else if(strstr($txt,"你最爱"))
	{
		echo "我爱的是你啊~,老公!";
	}
	else if(strstr($txt,"公司"))
	{
		echo "不用干活,天天坐着聊Q,玩妹子的公司!";
	}
	else 
	{
		echo "回答什么?";
	}
?>