<?php
include "config.php";
include "curl_cookie.php";

$user = explode(";", USER);
$choice = explode(";", CHOICE);
$email = explode(";", EMAIL);
$random = explode(";", RANDOM);
$hot = explode(";", HOT);
$pass = explode(";", PASS);

$n=count($user);

$week = date("w");
if($week>5) $week=5;
$dates = date("Y-m-d");
for($i = 0;$i < $n;$i++){
    if($user[$i] == '') continue;
    $choice_real = explode(",", $choice[$i]);
    $num_c = count($choice_real);
    //随机选择
    if($random[$i] ==1 || $num_c!=5){
        $arr=rand(0,$num_c-1);
        $c = $choice_real[$arr];
    }else{
        $c = $choice_real[$week-1];
    }

    $cookie ="./cookie".$user[$i];
    $curl_cookie = new CurlCookie($cookie);
    $tabUniqueId = $curl_cookie->get_tabUniqueId();

    //选择热门
    if($hot[$i] == 1){
      $c = $curl_cookie->get_order_id($tabUniqueId,$pass[$i]);
    }

    $reuslt = $curl_cookie->add_order($c,$tabUniqueId);

    if(strstr($reuslt,"SUCCESSFUL")){
        $meican = "订餐成功 ".$c;
    }else{
        $meican = "订餐失败 ".$c." ".$reuslt;
    }
    echo $meican;

    $curl_cookie->sent_emai($email[$i],$meican);

    sleep(1);
}
