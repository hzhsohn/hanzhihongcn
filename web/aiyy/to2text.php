<meta content="text/html; charset=utf-8" http-equiv="content-type" />

<?php

$AUDIO_FILE=$_REQUEST["pcm"];
if(''==$AUDIO_FILE)
{
echo 'no parameter = pcm';
exit;
}

echo $tokenUrl="http://www.hanzhihong.cn/aiyy/token.php";
echo "<br/>";
$j = file_get_contents($tokenUrl);
$j = json_decode(trim($j,chr(239).chr(187).chr(191)),true);
$token=$j['token'];
$cuid=$j['cuid'];

$url = "http://vop.baidu.com/server_api";

$audio = file_get_contents($AUDIO_FILE);
$base_data = base64_encode($audio);
$array = array(
        "format" => "pcm",
        "rate" => 8000,
        "channel" => 1,
        "lan" => "zh",
        "token" => $token,
        "cuid"=> $cuid,
        //"url" => "http://www.xxx.com/sample.pcm",
        //"callback" => "http://www.xxx.com/audio/callback",
        "len" => filesize($AUDIO_FILE),
        "speech" => $base_data,
        );
$json_array = json_encode($array);
$content_len = "Content-Length: ".strlen($json_array);
$header = array ($content_len, 'Content-Type: application/json; charset=utf-8');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_array);
$response = curl_exec($ch);
if(curl_errno($ch))
{
    print curl_error($ch);
}
curl_close($ch);
echo $response;
$response = json_decode($response, true);
var_dump($response);

?>
