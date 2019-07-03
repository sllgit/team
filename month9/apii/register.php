<?php

$username = $_POST['username'];
//$username = 'sll';

$password = $_POST['password'];
$repassword = $_POST['repassword'];

if(empty($username)){
    $code = [
        'code'=>1,
        'message'=>'username is not null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

if(empty($password)){
    $code = [
        'code'=>2,
        'message'=>'password is not null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}
if(empty($repassword)){
    $code = [
        'code'=>3,
        'message'=>'repassword is not null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}
if($password !== $repassword){
    $code = [
        'code'=>4,
        'message'=>'The password is inconsistent with the confirmation password',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

$link = mysqli_connect("127.0.0.1","root","root","1810b");

mysqli_set_charset($link,'utf8');

$sql = "select * from user where username='$username'";

$res = mysqli_query($link,$sql);

$data = mysqli_fetch_assoc($res);
if($data){
    $code = [
        'code'=>5,
        'message'=>'username is already exist',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}else{
   $sql2 = "insert into user (username,password) values ('$username','$password')";
   $res = mysqli_query($link,$sql2);
   if($res){
       $code = [
           'code'=>200,
           'message'=>'register is successfully',
           'data'=>[
               'username'=>$username,
               'password'=>$password
           ]
       ];
       echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
   }else{
       $code = [
           'code'=>-1,
           'message'=>'register is failed',
           'data'=>[]
       ];
       echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
   }
}


