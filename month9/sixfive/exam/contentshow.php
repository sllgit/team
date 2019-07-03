<?php
$title = $_POST['title'];
if(empty($title)){
    $code = [
        'code'=>1,
        'message'=>'title error',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

$link = mysqli_connect("127.0.0.1","root","root","blog");

mysqli_set_charset($link,'utf8');

$sql = "select * from article where title='$title'";

$res = mysqli_query($link,$sql);

$data = mysqli_fetch_assoc($res);
//var_dump($data);die;
if(empty($data)){
    $code = [
        'code'=>2,
        'message'=>'content is null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}else{
    $code = [
        'code'=>200,
        'message'=>'successfully',
        'data'=>$data['content']
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);
}

