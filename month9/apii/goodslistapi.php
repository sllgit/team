<?php

$start = curl_init();

curl_setopt_array($start,[
    CURLOPT_URL=>"http://www.1810b.com/api/goodslist.php",//请求地址

    CURLOPT_POST=>true,//是否为POST请求，为false那就是get请求

    CURLOPT_POSTFIELDS=>"table=goods",//POST传递的值，可以使数组，也可以是urdencode的字符串

    CURLOPT_FOLLOWLOCATION=>true,//如果设置为false，则不会进行301跳转，如果为true，则返回跳转后的内容

    CURLOPT_RETURNTRANSFER=>true,//接口的数据时直接输出还是返回得变量

]);

$res = curl_exec($start);

if(!$res){
    echo curl_error($start);die;
}
curl_close($start);

echo $res;