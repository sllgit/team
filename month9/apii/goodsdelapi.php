<?php

$goosaadd = curl_init();

curl_setopt_array($goosaadd,[
    CURLOPT_URL=>"www.1810b.com/api/goodsdel.php",
    CURLOPT_POST=>true,
    CURLOPT_POSTFIELDS=>"id=2",
    CURLOPT_FOLLOWLOCATION=>true,
    CURLOPT_RETURNTRANSFER=>true
]);

$re = curl_exec($goosaadd);
if(!$re){
    echo curl_error($goosaadd);die;
}
curl_close($goosaadd);

echo $re;
