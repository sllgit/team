<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    //登陆
    public function login(Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'password' => "required"
        ]);
        //var_dump(111);die;

        $name = $request->name;
        $password = $request->password;
        
        $res = Auth::attempt(['name'=>$name,'password'=>$password]);
        if($res){
            //生成令牌
            $user = Auth::user();
            $token = Str::random(60);
            $user->api_token = $token;
            $user->save();
            return ['token'=>$token];
        }
        response(['error'=>'用户名密码不正确'],407);
    }

    public function onelogin(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        $data = User::where(['name'=>$name])->first();
       if(!$data){
           return response(['error'=>'USERNAME NOT EXISTS'],404);
       }
       if(!password_verify($password,$data['password'])){
           return response(['error'=>'USERNAME OR PASSWORD IS FAILED']);
       }
       if(substr($data['api_token'],0,8) !== "onelogin"){
           return response(['error'=>'ORTHER LOGIN'],400);
       }else{

//           //生成该方法唯一标识的token
           $function = __FUNCTION__;
           $api_token = $function.Str::random(90);
           $data['api_token'] = $api_token;
           $data->save();
//           cookie('onelogin','1111111',1);
//           var_dump(cookie('onelogin'));die;
           return response('LOGIN SUCCESSFULLY',200);
       }
       //var_dump($data['api_token']);die;

    }

    public function twologin(Request $request)
    {

        $name = $request->name;
        $password = $request->password;
        $data = User::where(['name'=>$name])->first();
        if(!$data){
            return response(['error'=>'USERNAME NOT EXISTS'],404);
        }
        if(!password_verify($password,$data['password'])){
            return response(['error'=>'USERNAME OR PASSWORD IS FAILED']);
        }
        $login = substr($data['api_token'],0,8);
        if($login !== "twologin"){
            return response(['error'=>'ORTHER LOGIN IN '.strtoupper($login).' FUNCTION'],400);
        }else{
//           //生成该方法唯一标识的token
            $function = __FUNCTION__;
            $api_token = $function.Str::random(90);
            $data['api_token'] = $api_token;
            $data->save();
            return response('LOGIN SUCCESSFULLY',200);
        }

    }
}
