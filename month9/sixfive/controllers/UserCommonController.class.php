<?php

namespace controllers;
//所有的用户登录的接口都需要继承该类，用于验证usertoken (用户令牌)
use api\response;
use models\UserModel;

class UserCommonController extends Controller
{
    protected $user;
    public function __construct()
    {
        //继承父类构造函数
        parent::__construct();

        //验证令牌
        $this->verifyToken();

    }
    protected function verifyToken(){
        // 获取从客户端传递过来的token,从get或者post中传递过来的token
        $token = request()->all('usertoken');
        //header
        $request = request();

//        $token = $request->header('Authorixation') ? $request->header('Authorization') : ($request->all('usertoken') ? $request->all('usertoken') : "");

        // 通过token获取用户的信息
        $model = new UserModel();
        // 验证JWT token是否正确
        $res = $model->verifyToken($token);
//        var_dump($res);die;
        // 通过结果来判断是否放行
        if(is_string($res)){
            Response::gentype(401,$res);
        }else if(is_null($res)){
            Response::gentype(1005,"NOT EXISTS USER");
        }

        $this->user = $res;
    }
    
    //签名验证
    public function sign()
    {

    }

}