<?php

require_once("mydev/connection.m.php");
require_once("mydev/encode.m.php");

//数据库路径
$db_path=realpath('mydev/myip_db.mdb');

//////////////////////////////////////////////
//-----验证
if(strcmp($_GET["echostr"],''))
{
  ob_clean();
  echo $_GET["echostr"];exit;
}

//------------------------接收消息解释------------------------------
function ai_logic($Content)
{
global $db_path;
switch ($Content){
 case "你好":
   $Content="嗯,你好啊!";
   break;
 case "在吗？":
   $Content="不在，不过你可以说";
   break;
 case "HI":
   $Content="hello!";
   break;
 case "好累":
   $Content="我也是";
   break;
 case "做紧咩":
   $Content="无聊啊,我在发呆!!";
   break;
case "0":
   {
      $db=new CzhDB();
      $db->open_access($db_path);
      $db->query("select * from s_iplist where devname='台灯'");
      if($rs=$db->read())
      {
        $devname=$rs['devname']->value;
        $ipv=$rs['ipv']->value;
        $uptime=$rs['uptime']->value;
        $localip=$rs['localip']->value;
        $macaddr=$rs['macaddr']->value;
        $eport=$rs['eport']->value;
        $chipid=$rs['chipid']->value;
        
        $url="http://$ipv:$eport/0";
        $ch = curl_init() or die (curl_error());
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $Content = curl_exec($ch) or die (curl_error());
        curl_close($ch);
       }
       $db->close();
   }
   break;
case "1":
   {
      $db=new CzhDB();
      $db->open_access($db_path);
      $db->query("select * from s_iplist where devname='台灯'");
      if($rs=$db->read())
      {
        $devname=$rs['devname']->value;
        $ipv=$rs['ipv']->value;
        $uptime=$rs['uptime']->value;
        $localip=$rs['localip']->value;
        $macaddr=$rs['macaddr']->value;
        $eport=$rs['eport']->value;
        $chipid=$rs['chipid']->value;
        
        $url="http://$ipv:$eport/1";
        $ch = curl_init() or die (curl_error());
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $Content = curl_exec($ch) or die (curl_error());
        curl_close($ch);
       }
       $db->close();
   }
   break;
 default:
   $Content="唔明你讲咩!!";
} 
return $Content;
}
//发送文本功能
function send_text($ToUserName,$FromUserName,$Content)
{
echo '<xml>';
echo '<ToUserName>'.$ToUserName.'</ToUserName>';
echo '<FromUserName>'.$FromUserName.'</FromUserName>';
echo '<CreateTime>'.time().'</CreateTime>';
echo '<MsgType><![CDATA[text]]></MsgType>';
echo '<Content>'.$Content.'</Content>';
echo '</xml>'; 
}


//--------------------变量定义--
$ToUserName='';
$FromUserName='';
$CreateTime='';
$MsgType='';
$MsgId='';
$Content='';
$PicUrl='';
$Location_X='';
$Location_Y='';
$Scale='';
$Label='';
$Title='';
$Description='';
$Url='';
$Event='';
$EventKey='';


//--------------------处理文本--
$fxml = new DOMDocument();
$fxml->loadXML($GLOBALS['HTTP_RAW_POST_DATA']);
$node1 = $fxml->getElementsByTagName( "xml" );
foreach( $node1 as $n1 )
{
 $_ToUserName = $n1->getElementsByTagName( "ToUserName" );
 $ToUserName = $_ToUserName->item(0)->nodeValue;
 $_FromUserName = $n1->getElementsByTagName( "FromUserName" );
 $FromUserName = $_FromUserName->item(0)->nodeValue;
 $_CreateTime = $n1->getElementsByTagName( "CreateTime" );
 $CreateTime = $_CreateTime->item(0)->nodeValue;
 $_MsgType = $n1->getElementsByTagName( "MsgType" );
 $MsgType = $_MsgType->item(0)->nodeValue;
 
 switch($MsgType)
 {
  case 'text':
   $_Content = $n1->getElementsByTagName( "Content" );
   $Content = $_Content->item(0)->nodeValue;
  break;
  case 'image':
   $_PicUrl = $n1->getElementsByTagName( "PicUrl" );
   $PicUrl = $_PicUrl->item(0)->nodeValue;
  break;
  case 'location':
   $_Location_X= $n1->getElementsByTagName( "Location_X" );
   $_Location_Y= $n1->getElementsByTagName( "Location_Y" );
   $_Scale= $n1->getElementsByTagName( "Scale" );
   $_Label= $n1->getElementsByTagName( "Label" );
   $Location_X=$_Location_X->item(0)->nodeValue;
   $Location_Y=$_Location_Y->item(0)->nodeValue;
   $Scale=$_Scale->item(0)->nodeValue;
   $Label=$_Label->item(0)->nodeValue;
  break;
  case 'link':
   $_Title=$n1->getElementsByTagName( "Title" );
   $_Description=$n1->getElementsByTagName( "Description" );
   $_Url=$n1->getElementsByTagName( "Url" );
   $Title=$_Title->item(0)->nodeValue;
   $Description=$_Description->item(0)->nodeValue;
   $Url=$_Url->item(0)->nodeValue;
  break;
  case 'event':
   $_Event = $n1->getElementsByTagName( "Event" );
   $_EventKey= $n1->getElementsByTagName( "EventKey" );
   $Event = $_Event->item(0)->nodeValue;
   $EventKey= $_EventKey->item(0)->nodeValue;
  break;
 }
 
 $_MsgId = $n1->getElementsByTagName( "MsgId" );
 $MsgId = $_MsgId->item(0)->nodeValue;
}


//--------------------回复消息--
switch($MsgType)
{
 case 'text':
 {
  $Content=ai_logic($Content);
  send_text($FromUserName,$ToUserName,$Content);
 }
 break;
 case 'event':
 {
  switch($Event)
  {
   case 'subscribe'://subscribe(订阅)
    $Content="欢迎光临~!! 
你的OpenID:$FromUserName
订阅的公众号:$ToUserName";
    send_text($FromUserName,$ToUserName,$Content);
   break;
   case 'unsubscribe'://unsubscribe(取消订阅
   break;
   case 'CLICK'://CLICK(自定义菜单点击事件) 
   break; 
  }
 }
 break;
}

/*
//调试输出接收的内容
$fp=fopen("aaa.txt","w");
fprintf($fp,$GLOBALS['HTTP_RAW_POST_DATA']);
fclose($fp);
*/

?>