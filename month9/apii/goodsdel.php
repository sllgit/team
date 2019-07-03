<?php

$id = $_POST['id'];
if(empty($id)){
    $code = [
        'code'=>1,
        'message'=>'parameter error',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

$link = mysqli_connect("127.0.0.1","root","root","1810b");

mysqli_set_charset($link,'utf8');

$sql = "delete from goods where id='$id'";

$res = mysqli_query($link,$sql);

if($res){
    $code = [
        'code'=>200,
        'message'=>'delete is successfully',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}else{
    $code = [
        'code'=>-1,
        'message'=>'delete failed',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}

