<?php 
/////////////////////
function rep_cmd($str)
{
	//�滻IP
	$str=str_replace("%ip",$_SERVER['SERVER_NAME'],$str);
	return $str;
}
/////////////////////

?>