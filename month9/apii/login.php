<?php

//判断报文头中是否包含指定值
//if(!isset($_SERVER['HTTP_X_API_TOKEN']) || $_SERVER['HTTP_X_API_TOKEN'] != "1810b"){
//    exit (json_encode(['error'=>'拒绝访问'],JSON_UNESCAPED_UNICODE));
//}

$code = [
    'code'=>200,
    'message'=>'login is successfully',
    'data'=>[]
];

$username = $_POST['username'];
$password = $_POST['password'];

$link = mysqli_connect("127.0.0.1","root","root","1810b");

mysqli_set_charset($link,'utf8');

$sql = "select * from user";

$res = mysqli_query($link,$sql);

$data = mysqli_fetch_assoc($res);

if($data['username'] != $username){
    $code['code'] = 1;
    $code['message'] = 'username is undefined';
}else{
    if($data['password'] != $password){
        $code['code'] = -1;
        $code['message'] = 'login is failed';
    }else{
        unset($data['password']);
        $code['data']=$data;
    }
}
echo json_encode($code,JSON_UNESCAPED_UNICODE);
