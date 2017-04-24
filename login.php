<?php
include "config.php";
include "curl_cookie.php";

$user = explode(";", USER);
$password = explode(";", PASSWORD);
$n=count($user);

for($i = 0;$i < $n;$i++){
    if($user[$i] == '') continue;
    $cookie ="./cookie".$user[$i];
    $curl_cookie = new CurlCookie($cookie);
    $curl_cookie->login($user[$i],$password[$i]);

    $handle = fopen($cookie, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
    //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
    $contents = fread($handle, filesize ($cookie));
    fclose($handle);
    //echo $contents;
    if(strstr($contents,"success"))
    {
        echo $user[$i]."登录成功\n";
    }else{
        echo $user[$i]."登录失败\n";
    }
    //连续几个账号，必须间隔时间，不然会报错
    sleep(1);
}
