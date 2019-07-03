<?php

namespace controllers;
//所有的用户登录的接口都需要继承该类，用于验证usertoken (用户令牌)
use api\response;
use models\UserModel;

class UserCommonController2 extends Controller
{
    protected $user;
    public function __construct()
    {
        //继承父类构造函数
        parent::__construct();

        //验证令牌
        $this->verifyToken();

    }
    protected function verifyToken()
    {
        //接收传过来的token值
        $usertoken = request()->all('usertoken');
        //通过token去查询用户
        $model = new UserModel();
        $res = $model->getUserInfoByUserToken($usertoken);
        if(!$res){
            response::gentype(401, "UNAUTHORIZATION");
        }
        //验证时间是否过期
        if($res['expiretime'] < time()){
            response::gentype(1004, "EXPIRE USRETOKEN");
        }
        //都正确则赋值给user
        $this->user = $res;
    }

}