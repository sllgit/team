<?php
function dd($val){
    var_dump($val);die;
}
function request()
{
    //保证全局只有一个request对象
    static $request = null;
    if(!$request instanceof Request){
        $request = new Request();
    }
    return $request;
}

function config($name = ''){
    $config = sixfive\Config::getInstance();
    if($name){
        return $config->getConfig($name);
    }
    return $config->getConfig();
}

//加密
function encrypt($data,$key,$iv){
    return openssl_encrypt($data,"AES-128-CBC",$key,0,$iv);
}
//解密
function decrypt($data,$key,$iv){
    return openssl_decrypt($data,"AES-128-CBC",$key,0,$iv);
}

function setLog($name,$data,$info=[]){
//    var_dump(new \Monolog\Logger($name));die;
//    static $logger = null;
//    if($logger instanceof \Monolog\Logger){
        $logger = new \Monolog\Logger($name);
//    }
    $file = LOG_PATH.'/'.date("Y-m-d").'.log';
    if(!file_exists($file)){
        file_put_contents($file,"");
    }
//var_dump($logger);die;
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($file,MonoLog\Logger::DEBUG));

    $logger->addInfo($data,$info);
}