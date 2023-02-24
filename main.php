<?php
error_reporting(0);

//接口信息
$puzzleToken = "8bb72d21ee65e325c548da0e04bdd3eb";
$reviewApiUrl = "https://bingdun.apis.show/api/review?puzzle_token=".$puzzleToken;
$authID = "6e565a15d7da27b5d1c949357761a8e4";
$authSecretKey = "912097369277ecb5dac3d1bd7ab00d2e";
$timeAt = "1675750472";

//生成签名
$sign = hash_hmac('sha256', $puzzleToken, $authID);

//组装参数
$query = array(
    "auth_id" => $authID,
    "auth_secret_key" => $authSecretKey,
    "time_at" => $timeAt,
    "sign" => $sign,
);

$res = requestPost($reviewApiUrl, $query);
var_dump($res);

if (isset($res["code"]) && $res["code"]==0) {
    //二次校验成功 开始处理业务逻辑
}else{
    //二次校验失败
}

// requestPost
function requestPost($url, $postData)
{
    $data = http_build_query($postData);

    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-type: application/json",
            'content' => $data,
            'timeout' => 10
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $arrData = json_decode($result, TRUE);
    if (isset($arrData["code"]) && $arrData["code"] == 0) {
        return $arrData;
    } else {
        return [];
    }
}