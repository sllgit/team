<?php

$goosaadd = curl_init();

curl_setopt_array($goosaadd,[
    CURLOPT_URL=>"www.1810b.com/api/goodsupd.php",
    CURLOPT_POST=>true,
    CURLOPT_POSTFIELDS=>"id=1&goods_name=aa&goods_price=10&goods_num=5&goods_desc=aaaa",
    CURLOPT_FOLLOWLOCATION=>true,
    CURLOPT_RETURNTRANSFER=>true
]);

$re = curl_exec($goosaadd);
if(!$re){
    echo curl_error($goosaadd);die;
}
curl_close($goosaadd);

echo $re;
