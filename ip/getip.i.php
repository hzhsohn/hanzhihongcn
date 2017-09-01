<?php
$title=$_REQUEST['title'];

$filen="./db.txt";

$fp=fopen($filen,"r");
if($fp)
{
  $json=fread($fp,filesize($filen));
  $json=json_decode($json);
  $obj=$json->$title;  
  if($obj)
  {
    echo '{"result":true,"msg":"success",';
    $ipv=$obj->ipv;
    $uptime=$obj->uptime;
    echo "\"title\":\"$title\",\"time\":\"$uptime\",\"ip\":\"$ipv\"";
    echo '}';
  }
}
else
{
  echo '{"result":false,"msg":"not found title"}';
}
fclose($fp);


?>