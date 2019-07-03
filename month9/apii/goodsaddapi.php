<?php

$goosaadd = curl_init();

curl_setopt_array($goosaadd,[
    CURLOPT_URL=>"www.1810b.com/api/goodsadd.php",
    CURLOPT_POST=>true,
    CURLOPT_POSTFIELDS=>"goods_name=商品&goods_price=100&goods_num=10&goods_desc=好东西",
    CURLOPT_FOLLOWLOCATION=>true,
    CURLOPT_RETURNTRANSFER=>true
]);

$re = curl_exec($goosaadd);
if(!$re){
    echo curl_error($goosaadd);die;
}
curl_close($goosaadd);

echo $re;
