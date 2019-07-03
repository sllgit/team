<?php

$table = $_POST['table'];
if(empty($table) || $table != 'article'){
    $code = [
        'code'=>1,
        'message'=>'table error',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

$link = mysqli_connect("127.0.0.1","root","root","blog") or die("content failed");

mysqli_set_charset($link,'utf8');

$sql = "select * from article where status=1";

$res = mysqli_query($link,$sql);

//var_dump($res);die;
if(empty($res)){
    $code = [
        'code'=>2,
        'message'=>'list is null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}else{
    while($data = mysqli_fetch_assoc($res)){
        $info[] =$data;
    }
    $code = [
        'code'=>200,
        'message'=>'successfully',
        'data'=>$info
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}

