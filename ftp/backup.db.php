<?php
require_once('../_config.php');
require_once('../_module/mysql.m.php');
require_once('../_module/encode.m.php');

echo "please reset code"
exit;

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);

$aaaa=array();

$db->query("select*from information");
while($rs=$db->read())
{
   $aaaa[]=$rs[0];
   echo $rs[0].'</br>';
}

foreach($aaaa as $a)
{
    $db->query("select*from information where autoid=".$a);
    if($rs=$db->read())
    {
       $str="insert into tbnote(ip,typetwo_id,title,content,uptime) values('".$rs["ip"]."','".$rs["typetwo_id"]."','".$rs["title"]."','".$rs["content"]."','".$rs["uptime"]."')";
    
      if($db->query($str))
      echo 'do-----'.$rs[0].'</br>';
      else
      echo 'err-----'.$rs[0].'</br>';
    }
}
$db->close();

?>