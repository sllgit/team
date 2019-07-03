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

$sql = "select * from goods where id='$id'";

$res = mysqli_query($link,$sql);

$data = mysqli_fetch_assoc($res);
//var_dump($data);die;

if(empty($data)){
    $code = [
        'code'=>2,
        'message'=>'id not exists',
        'data'=>[]
    ];
    echo json_encode($code,JSON_UNESCAPED_UNICODE);die;
}else{
//    var_dump($data);
    $goods_name = $_POST['goods_name'] ? $_POST['goods_name'] : $data['goods_name'];
    $goods_price = $_POST['goods_price'] ? $_POST['goods_price'] : $data['goods_price'];
    $goods_num = $_POST['goods_num'] ? $_POST['goods_num'] : $data['goods_num'];
    $goods_desc = $_POST['goods_desc'] ? $_POST['goods_desc'] : $data['goods_desc'];

    $sql2 = "update goods set goods_name='$goods_name',goods_price='$goods_price',goods_num='$goods_num',goods_desc='$goods_desc' where id='$id'";

    $res2 = mysqli_query($link,$sql2);
//    var_dump($res2);die;
    if($res2){
        $code = [
            'code'=>200,
            'message'=>'update is successfully',
            'data'=>[
                'goods_name'=>$goods_name,
                'goods_price'=>$goods_price,
                'goods_num'=>$goods_num,
                'goods_desc'=>$goods_desc,
            ]
        ];
        echo json_encode($code,JSON_UNESCAPED_UNICODE);
    }else{
        $code = [
            'code'=>-1,
            'message'=>'update failed',
            'data'=>[]
        ];
        echo json_encode($code,JSON_UNESCAPED_UNICODE);
    }

}

