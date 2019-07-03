<?php


$register = curl_init();

curl_setopt_array($register,[
    CURLOPT_URL=>'http://www.1810b.com/api/register.php',
    CURLOPT_POST=>true,
    CURLOPT_POSTFIELDS=>"username=zhu&password=123&repassword=123",
    CURLOPT_FOLLOWLOCATION=>true,
    CURLOPT_RETURNTRANSFER=>true,

]);

$re = curl_exec($register);
if(!$re){
    echo curl_error($register);die;
}

curl_close($register);

echo $re;