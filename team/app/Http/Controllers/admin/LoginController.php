<?php

namespace App\Http\Controllers\admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LoginController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    /*
     * @content 登录
     * */
    public function login(){
        return view('admin.login');
    }
    /*
     * @content 登录验证
     * */
    public function logindo(Request $request){
        $username=$request->username;
        $password=$request->password;
        $where=[
            'username'=>$username,
            'password'=>$password
        ];
        $res=User::where($where)->first();
        if(empty($res)){
            echo "<script>alert('账号或密码有误');location.href='/admin/login'</script>";
        }else{
            session(['username' => $username]);
            echo "<script>alert('登陆成功');location.href='/admin/index'</script>";
        }
    }
    /*
     * @content 退出
     * */
    public function quit(Request $request){
        $request->session()->flush();
        return redirect(url('admin/login'));
    }
}
