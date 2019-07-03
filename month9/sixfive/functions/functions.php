<?php
function demo(){
    echo __FUNCTION__;
}
function createSign($data = [])
{
    //生成随机数
    $randstr = createRendstring();
    //生成时间戳
    $timestamp = time();
    //key
    $key = "1810b";

    $signArr = ['timestamp'=>$timestamp,'noncestr'=>$randstr,'key'=>$key];
    $signArr = $signArr + $data;
    sort($signArr,SORT_STRING);
    $sign = sha1(implode($signArr));
//    dd($signArr);
    return [$randstr,$timestamp,$sign];

}

//随机生成字符串
function createRendstring($len = 20)
{
    $randstr = '';
    $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$";
    for ($i=1;$i<=$len;$i++){
        $index = rand(0,strlen($string)-1);
        $randstr .= $string[$index];
        //echo $randstr;
    }
    return $randstr;
}