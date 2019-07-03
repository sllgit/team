<?php

$goods_name = $_POST['goods_name'];
$goods_price = $_POST['goods_price'];
$goods_num = $_POST['goods_num'];
$goods_desc = $_POST['goods_desc'];

if(empty($goods_name)){
    $code = [
        'code'=>1,
        'message'=>'goods_name is not null',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}

$link = mysqli_connect("127.0.0.1","root","root","1810b");

mysqli_set_charset($link,'utf8');

$sql = "insert into goods (goods_name,goods_price,goods_num,goods_desc) values ('$goods_name','$goods_price','$goods_num','$goods_desc')";

$res = mysqli_query($link,$sql);
//var_dump($res);die;
if($res){
    $code = [
        'code'=>200,
        'message'=>'goodsadd is successfully',
        'data'=>[
            'goods_name'=>$goods_name,
            'goods_price'=>$goods_price,
            'goods_num'=>$goods_num,
            'goods_desc'=>$goods_desc,
        ]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;

}else{
    $code = [
        'code'=>-1,
        'message'=>'goodsadd is failed',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;

}