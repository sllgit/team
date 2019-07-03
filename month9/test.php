<?php

//// 1. curl 初始化
//
//$ch = curl_init();
//// 2. 设置参数
//curl_setopt($ch,CURLOPT_URL,"http://www.slszkj.com");
//curl_setopt($ch,CURLOPT_POST,false);
//curl_setopt($ch,CURLOPT_POSTFIELDS,"username=zhangsan&password=123");
//
//curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
//curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//
////curl_setopt_array(ch, options)
//// 3. 执行
//
//
//$res = curl_exec($ch);
//
//// 可能会发生错误
//if(!$res){
//    echo curl_error($ch);
//    exit;
//}
//
//// 4. 关闭
//curl_close($ch);
//
//var_dump($res);
require_once "api/response.class.php";

api\response::gentype('200','ok',['name'=>'zhangsan','sex'=>'男','son'=>['son1'=>'zhangsi','sex'=>'女','son2'=>['name'=>'zhangwu','sex'=>'男']]]);
//$arr = [
//    'code'=>'100',
//    'message'=>'',
//    'data'=>[
//        'name'=>'zhang1',
//        'age'=>20,
//        'son'=>[
//            'son1'=>[
//                'name'=>'zhang2',
//                'age'=>10,
//                'son2'=>[
//                    'name'=>'zhang3',
//                    'age'=>1
//                ]
//            ]
//        ]
//    ]
//];
\api\response::gentype('200','ok',$arr);

//require_once "sixfive/http.class.php";

//\sixfive\Http::postHttp('http://www.1810b.com/api/register.php',['username'=>'xiaobailong','password'=>'250','repassword'=>'250']);

//引入自动加载


