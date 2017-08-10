<?php
include "config.php";
include "curl_cookie.php";

$user = explode(";", USER);

$cookie ="./cookie".$user[0];

$curl_cookie = new CurlCookie($cookie);

$dates = date("Y-m-d");
$tabUniqueId = $curl_cookie->get_tabUniqueId();

$url = array(
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378075785&restaurantUniqueId=354131&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378570665&restaurantUniqueId=26d414&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378599468&restaurantUniqueId=9f5677&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378620915&restaurantUniqueId=36d39e&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378641049&restaurantUniqueId=324deb&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378659931&restaurantUniqueId=c2d7ce&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378678666&restaurantUniqueId=5658d5&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00",
  "https://meican.com/preorder/api/v2.1/restaurants/show?noHttpGetCache=1502378720547&restaurantUniqueId=61f05d&tabUniqueId=$tabUniqueId&targetTime=$dates+17:00");

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
