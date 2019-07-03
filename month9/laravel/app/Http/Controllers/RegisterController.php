<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //注册
    public function res()
    {
        return view('reg');
    }
    //注册2
    public function reg(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'tel'=>'required',
            'pwd'=>'required',
            'repwd'=>'required',
            'code'=>'required',
        ]);
        $user = User::where(['tel'=>$data['tel']])->first();
        if($user){
            return response(['error'=>'此手机号已经注册过，换一个试试']);
        }
        if($data['pwd'] !== $data['repwd']){
            return response(['error'=>'密码与确认密码不一致']);
        }

        $code = session('code');
//        dd($code);
        if($data['code'] !== $code){
            return response(['error'=>'验证码不正确']);
        }
        unset($data['code']);
        $data['pwd'] = password_hash($data['pwd'],PASSWORD_DEFAULT);

        $key = '1810b';
        $sign = openssl_encrypt(json_encode($data),'DES-ECB',$key);
        session()->put('sign',$sign);
//        dd($data);

        $res = User::create($data);

        if($res){
            return response(['data'=>'ok'],200);
        }else{
            return response(['error'=>'注册失败']);
        }
    }

    //登录
    public function logins()
    {
        return view('login');
    }
    public function logins2()
    {
        return view('login2');
    }

    public function logined()
    {
        if(Redis::get('login') !== session('login')){
            return response(['error'=>'在其他地方登录']);
        }
       $data = \request()->all();
       $user = User::where(['tel'=>$data['tel']])->first();
       if(!$user) {
           return response(['error' => '该用户还未注册']);
       }

       if(!password_verify($data['pwd'],$user['pwd'])){
           return response(['error'=>'密码不正确']);
       }

       //生成一个随机数
       $aa = Str::random(10);

        setcookie('login',$aa,time()+60,'/','1810blaravel.com',false,true);
        Redis::setex('login',7200,$aa);
       return response(['error'=>'登录成功']);

    }

    public function logined2()
    {
        if(Redis::get('login') !== session('login')){
            return response(['error'=>'在其他地方登录']);
        }
        $data = \request()->all();
        $user = User::where(['tel'=>$data['tel']])->first();
        if(!$user) {
            return response(['error' => '该用户还未注册']);
        }

        if(!password_verify($data['pwd'],$user['pwd'])){
            return response(['error'=>'密码不正确']);
        }
        //生成一个随机数
        $aa = Str::random(10);

        session()->put('login',$aa);

        Redis::setex('login',7200,$aa);
        return response(['error'=>'登录成功']);

    }
    //生成验证码
    public function sendcode()
    {
        $time = session('time');

        if($time + 60 >time()){
           return response(['error'=>'验证码一分钟内只能发一次']);
        }
        $info="";
        $pattern = '1234567890';
        for($i=0;$i<4;$i++) {
            $info .= $pattern{mt_rand(0,9)};    //生成php随机数
        }
        session()->put('code',$info);

        session()->put('time',time());
        echo $info;

    }

    //签名
    public function sign($data,$len=20)
    {
        //生成随机数
        $randstr = '';
        $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$";
        for ($i=1;$i<=$len;$i++){
            $index = rand(0,strlen($string)-1);
            $randstr .= $string[$index];
        }
        //生成时间戳
        $timestamp = time();
        //key
        $key = "1810b";

        $signArr = ['timestamp'=>$timestamp,'noncestr'=>$randstr,'key'=>$key];
        $signArr = $signArr + $data;
        sort($signArr,SORT_STRING);
        $sign = sha1(implode($signArr));
        dd($sign);

    }
}
