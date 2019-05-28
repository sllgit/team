<?php

namespace App\Http\Controllers\home;

use App\Model\Menu;
use App\Model\Music;
use App\Model\User;
use App\Model\Users;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tools\JSSDK;
class IndexController extends Controller
{
    /**
     * @return 获取微信授权登录的code
     */
    public function getcode()
    {
        $appid = env('APPID');
        $redirect_url = urlencode("http://47.93.2.112/admin/wxlogin");
        //用户同意授权，获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_url&response_type=code&scope=snsapi_userinfo&state=1234567#wechat_redirect";
        header('location:'.$url);
    }
    /**
     * @content 授权登录
     */
    public function wxlogin()
    {
        $code = \request()->code;
        $APPID = env('APPID');
        $APPSECRET = env('APPSECRET');
        //通过code换取网页授权access_token
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$APPSECRET&code=$code&grant_type=authorization_code";
        $info = file_get_contents($url);
        $token = json_decode($info,true)['access_token'];
        $openid = json_decode($info,true)['openid'];
        //拉去用户信息
        $userurl = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $userinfo = file_get_contents($userurl);
        $data = json_decode($userinfo,true);
        $userinfo = Users::where('openid',$openid)->first();
//        dd($userinfo);
        if(empty($userinfo)){
            $data = serialize($data);
            return view('admin/binding',compact('data'));
        }else{
            \request()->session()->put('users',$data);
            return redirect('/');
        }
    }

    /**
     * @content 微信绑定登录执行
     */
    public function bindingdo()
    {
        $name = \request()->name;
        $user = unserialize(\request()->user);
//        dump($user);
        $userinfo = Users::where('username',$name)->first();
        if(empty($userinfo)){
            echo "<script>alert('暂无此用户');location.href='/admin/getcode'</script>";
        }else{
            $data = [
                'openid'=>$user['openid'],
                'nickname'=>$user['nickname'],
                'headimgurl'=>$user['headimgurl'],
                'address'=>$user['country'].$user['province'].$user['city']
            ];
            $res = Users::where('username',$name)->update($data);
            if($res){
                \request()->session()->put('users',$data);
//                echo "<script>alert('绑定成功');location.href='/'</script>";
                echo 1;
            }else{
//                echo "<script>alert('绑定失败');location.href='/admin/getcode'</script>";
                echo 2;
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View电影音乐前台首页
     */
    public function index()
    {

        $sign = $this->sign;
        $users = \request()->session()->get('users');
//        dd($users);
        $chinaese = Music::where(['mstatus'=>1,'mtype'=>'中文'])->orderBy('mid','desc')->limit(5)->get();
        $english = Music::where(['mstatus'=>1,'mtype'=>'英文'])->orderBy('mid','desc')->limit(5)->get();
        $vdata = Video::where('vstatus',1)->orderBy('vid','desc')->limit(8)->get();
//        dump($mdata);
//        dump($vdata);die;
        return view('home/index',['vdata'=>$vdata,'chinaese'=>$chinaese,'english'=>$english,'users'=>$users,'sign'=>$sign]);
    }

	 /*
     * @content 搜索
     */
    public function search(Request $request)
    {
        $value=$request->keyword;
        if(!empty($value)){
            $con=Music::where('mname','like',"%$value%")->get()->toArray();
            $con1=Video::where('vname','like',"%$value%")->get()->toArray();
        }
//        dump($con);
//        dd($con1);
        return view('home/search',compact('con','con1'));
    }
}
