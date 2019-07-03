<?php
namespace controllers;

use api\response;
use models\UserModel;

class UserController2 extends UserCommonController2
{
    public function Login()
    {
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
        //密码正确 生成token
        $usertoken = $this->checkUserToken(30);
        $expiretime = time()+7200;
        $ress = $model->exec("update __table__ set usertoken=?,expiretime=? where username=?",[$usertoken,$expiretime,$username]);
        if(!$ress){
            response::gentype(500, "INTERNAL ERROR");
        }
        response::gentype(200, "LOGIN SUCCESSFULLY",['usertoken'=>$usertoken,'expiretime'=>$expiretime]);



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