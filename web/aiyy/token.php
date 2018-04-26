<?php

//put your params here
$cuid = "xxxx123";
$apiKey = "OVjML0Ujsk7oamgYL82yKGNE";
$secretKey = "CEkRADHQhUFRrQymDTG5uAGMmckwEozo";

$auth_url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$apiKey."&client_secret=".$secretKey;

$response = file_get_contents($auth_url);
$response = json_decode($response, true);

$token = $response['access_token'];

$ary=array("cuid"=>$cuid,"token"=>$token);
echo json_encode($ary);

?>
