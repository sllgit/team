<?php

namespace App\Http\Controllers;

use App\Model\Music;
use App\Model\Subscribe;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Wxshop\wxchat;
use DB;

class WxController extends Controller
{
    /*
     * @content 判断是否接入成功 关注后调用回复
     * */
    public function wxshop(Request $request)
    {
        $echostr = $request->echostr;
        if(isset($echostr)){
            if($this->checkSigbature($request)){
                echo $echostr;
            }
        }else{
            $this->responseMsg();
        }

    }
    /*
     * @content 接收微信消息推送
     * */
    public function responseMsg()
    {
        //接收推送过来的信息
        $postStr = file_get_contents("php://input");

//        is_dir('logs') or mkdir('logs',0777,true);
//        file_put_contents('logs/wx.text',$postStr,FILE_APPEND);
        //处理xml
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
//        dd($postObj);
        $FromUserName = $postObj->FromUserName;
        $ToUserName = $postObj->ToUserName;
        $keywords = $postObj->Content;
        //判断是不是事件
        if($postObj->MsgType == 'event'){
            //判断是不是关注事件
            if($postObj->Event == 'subscribe') {
                $settype = config('wechat.responsetype');
//                $settype = 'text';
                $res = Subscribe::where(['type'=>$settype])->orderBy('create_time','desc')->first();
//                dd($res);
                $type = ucfirst($res->type);
                $getMessage = 'send'.$type.'Message';
                switch ($settype)
                {
                    case 'text':
                        $data = $res->content;
                        echo wxchat::$getMessage($FromUserName,$ToUserName,$data);
                        break;
                    case 'image':
                        $data = $res->media_id;
                        echo wxchat::$getMessage($FromUserName,$ToUserName,$data);
                        break;
                    case 'voice':
                        $data = $res->media_id;
                        echo wxchat::$getMessage($FromUserName,$ToUserName,$data);
                        break;
                    case 'news':
                        $data = $res;
                        echo wxchat::$getMessage($FromUserName,$ToUserName,$data);
                        break;

                }
            }
        }
//        //自定义关键字回复
        if($keywords == '你好'){
            $content = "你好，这里是音乐电影系统，祝你在这里快乐度过每一天";
            echo wxchat::sendTextMessage($FromUserName,$ToUserName,$content);
        }elseif ($keywords == '图片'){
            wxchat::sendImageMessage($FromUserName,$ToUserName);
        }elseif ($keywords == '语音'){
            wxchat::sendVoiceMessage($FromUserName,$ToUserName);
        }elseif (strstr($keywords,'电影')) {
            //获取电影名称
            $videoname = wxchat::getVideoName($keywords);
            //根据电影名称查询有没有电影
            $videoinfo = Video::where('vname', $videoname)->first();
//            dd($videoinfo);
                if (empty($videoinfo)) {
                //没有
                $content = "亲，本网站暂无此电影，我们会尽快上传";
                echo wxchat::sendTextMessage($FromUserName, $ToUserName, $content);
            } else {
                //有 发送模板信息
                wxchat::GetVideoMessage($FromUserName, $ToUserName, $videoinfo);

            }
        }elseif (strstr($keywords,'音乐')) {
            //获取电影名称
            $musicname = wxchat::getMusicName($keywords);
            //根据电影名称查询有没有电影
            $musicinfo = Music::where('mname', $musicname)->first();
//            dd($videoinfo);
            if (empty($musicinfo)) {
                //没有
                $content = "亲，本网站暂无此音乐，我们会尽快上传";
                echo wxchat::sendTextMessage($FromUserName, $ToUserName, $content);
            } else {
                //有 发送模板信息
                wxchat::GetMusicMessage($FromUserName, $ToUserName, $musicinfo);
            }
        }elseif($keywords == '登录'){
            $appid = env('APPID');
            $uri = urlencode("http://47.93.2.112/admin/wxlogin");
            $content = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=1234567#wechat_redirect";
            echo wxchat::sendTextMessage($FromUserName,$ToUserName,$content);
        }else{
            //没有该关键字则图灵机器人回复
            $url ="http://openapi.tuling123.com/openapi/api/v2";//接口地址
            $content = wxchat::rbot($keywords,$url);
            echo wxchat::sendTextMessage($FromUserName,$ToUserName,$content);

        }
    }

    /*
     * @content 处理微信第一次接入
     * @return 成功返回true 失败返回false
     * */
    public function checkSigbature(Request $request)
    {
        $signature = $request->signature;
        $nonce = $request->nonce;
        $timestamp = $request->timestamp;
        $token = env('TOKEN');
//        dd($token);
        $tmpArr  = array($token,$timestamp,$nonce);
        sort($tmpArr ,SORT_STRING);
        $tmpStr = implode($tmpArr );
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

}
