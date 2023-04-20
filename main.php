<?php
error_reporting(0);

//接口信息
$puzzleToken = "your puzzle_token";
$reviewApiUrl = "https://bingdun.apis.show/api/review?puzzle_token=".$puzzleToken;
$authID = "your auth_id";
$authSecretKey = "your auth_secret_key";
$timeAt = time();


//生成签名
$sign = hash_hmac('sha256', $puzzleToken, $authID);

//组装参数
$parameters = array(
    "auth_id" => $authID,
    "auth_secret_key" => $authSecretKey,
    "time_at" => $timeAt,
    "sign" => $sign,
);

$res = requestPost($reviewApiUrl, $parameters);
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

    return $arrData;
}