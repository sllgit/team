<?php
namespace controllers;

use api\response;
use models\UserModel;

class UserController extends UserCommonController
{
    public function Login()
    {
//        dd(111);die;
        $username = request()->all('username');
        $password = request()->all('password');
        //判断是否有该用户
        $model = new UserModel();
        $res = $model->getUserInfoByUserName($username);

        if(!$res) {
            response::gentype(1002, "NOT EXISTS USERNAME");
        }
        //判断密码是否正确
        if(!password_verify($password,$res['password'])){
            response::gentype(1003, "PASSWORD IS FAILED");
        }
        unset($res['password']);

        $res = encrypt(json_encode($res),config("userToken.key"),config("userToken.iv"));
//        var_dump($res['id']);die;
        //密码正确 生成token
        $usertoken = $model->createToken($res);
        var_dump($usertoken);
        //response::gentype(200, "LOGIN SUCCESSFULLY",['usertoken'=>$usertoken,'expiretime'=>$expiretime]);



    }
    //生成usertoken
    public function checkUserToken($len)
    {
        $uniqid = uniqid();
        $str = createRendstring($len-strlen($uniqid));
        $usertoken = $uniqid.$str;
        return $usertoken;
    }
}