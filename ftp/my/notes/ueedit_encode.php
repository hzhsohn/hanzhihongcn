<?php
function ueTrSql($theString)
{
		$theString = str_replace('\n','[#ue_pole#n]',  $theString);
		return $theString; 
}
function ueTrHtml($theString)
{	
		$theString = str_replace("[#ue_pole#n]", '\n',$theString);
		return $theString; 
}
?>
