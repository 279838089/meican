<?php
include "config.php";
include "curl_cookie.php";

$user = explode(";", USER);

$cookie ="./cookie".$user[0];

$curl_cookie = new CurlCookie($cookie);

$dates = date("Y-m-d");
$tabUniqueId = $curl_cookie->get_tabUniqueId();

$url = array("https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492671821559&restaurantUniqueId=fc4c3e&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492687964482&restaurantUniqueId=c2d7ce&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492673754541&restaurantUniqueId=5658d5&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492673771393&restaurantUniqueId=26d414&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492673786768&restaurantUniqueId=50ff5c&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1492673799150&restaurantUniqueId=94cf21&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00","https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1495435516064&restaurantUniqueId=a24048&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00");

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
foreach ($url as $k => $value_url) {
    $get_c=  $curl_cookie->get_content($value_url,$cookie);
    $res = json_decode($get_c);
    echo $res->name;
    echo "<br>";
    foreach ($res->dishList as $key => $value) {
       echo "id: $value->id @ name: $value->name";
       echo "<br>";
    }
    echo "<br><hr><br>";
}
