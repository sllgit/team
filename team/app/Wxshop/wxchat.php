<?php

namespace App\Wxshop;

use App\Model\Openiduserinfo;
use App\Model\Subscribe;
use App\Model\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class wxchat extends Model
{
    /**
     * @content 文件上传
     * @param $file 文件的信息
     * @return array  返回文件类型和路径的数组
     */
    public static function UploadsFile($file)
    {
        //获取上传文件的后缀  image/jpg
        $ext = $file->getclientoriginalextension();
        //获取上传文件的类型
        $type = $file->getClientMimeType();
        //获取当前文件的位置
        $path = $file->getRealPath();
        //拼接新文件路径
        $newPath = "/wechat/".date("Ymd")."/".rand(10000,99999).".".$ext;
        //降临时文件移动到对应文件夹
        $re = Storage::disk('uploads')->put($newPath,file_get_contents($path));
//        dd($re);
        if($re){
            $data = [
                'ext'=>$type,
                'path'=>$newPath
            ];
            return $data;
        }else{
            echo "<script>alert('操作失败，请重试');location.href='/admin/add'</script>";die;
        }
    }


    /**
     * @content 获取素材所需要的类型
     * @param $ext 文件类型和路径的数组
     * @return mixed 返回文件的类型
     */
    public static function GetMaterialType($ext)
    {
        $info = explode('/',$ext);
        $type =$info[0];

//      dd($type);
        $arr_type = ['image','audio','video'];
        if(in_array($type,$arr_type)){
            $return_type =[
                'image'=>'image',
                'audio'=>'voice',
                'video'=>'video'
            ];
            return $return_type[$type];
        }else{
            echo "<script>alert('文件格式不允许，请重新上传');location.href='/admin/add'</script>";die;
        }
    }

    /**
     * @cotent 获取access_token
     * @return false|string  返回token值
     */
    public static function GetAccessToken()
    {
        //获取token.txt的路径
        $fileName = public_path()."/token.txt";
        //获取文件的内容
        $str = file_get_contents($fileName);
        //获取token expire (过期时间)  存字符串
        $info = json_decode($str,true);
        $redis = cache('info');
        if($info['expire']<time() || !$redis){

            //过期了 需要重新生成
            $token = self::CreateAccessToken();
            $expire = time()+7000;
            $data = ['token'=>$token,'expire'=>$expire];
            $info = json_encode($data);
            //把token和repire过期时间存入文件中
            file_put_contents($fileName,$info);
            //把token和repire过期时间存入redis中
            cache(['info'=>$info],7000);
        }else{
            //没过期 拿出来
            $token = $info['token'];
        }
        return $token;
    }

    /**
     * @content 生成access_token
     * @return false|string 返回生成的access_token
     */
    static private function CreateAccessToken()
    {
        $appid = env('APPID');
        $appsecret = env('APPSECRET');
        $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        //可以发起个头请求的方式 ajax href src curl file_get_contents guzzle
        //把生成的access_token写入字符串中
        return file_get_contents($token_url);
    }

    /**
     * @param $url url接口
     * @param $post_data post数据
     * @return bool|mixed|string 返回获得的数据的内容
     */
    public static function HttpPost($url,$post_data)
    {
        //初始化
        $curl = curl_init();
        //dd($curl);
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //忽略SSL证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        $data = json_decode($data,true);
        return $data;

    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @param $content 回复信息的内容
     * @return string  返回文本的json数据包
     */
    public static function sendTextMessage($fromusername,$tousername,$content)
    {
        $time = time();
        $texttpl = "<xml>
                          <ToUserName><![CDATA[$fromusername]]></ToUserName>
                          <FromUserName><![CDATA[$tousername]]></FromUserName>
                          <CreateTime>$time</CreateTime>
                          <MsgType><![CDATA[text]]></MsgType>
                          <Content><![CDATA[$content]]></Content>
                        </xml>";
        return $texttpl;
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @return string 图片的模板
     */
    public static function sendImageMessage($fromusername,$tousername)
    {
        $res = DB::table('subscribe')->where(['type'=>'image'])->orderBy('id','desc')->first();
        $media_id = $res->media_id;
        $time = time();
        $imagetpl ="<xml>
                      <ToUserName><![CDATA[$fromusername]]></ToUserName>
                      <FromUserName><![CDATA[$tousername]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[$media_id]]></MediaId>
                      </Image>
                    </xml>";
        echo $imagetpl;die;
    }

    /**
     * @param $keywords 关键字
     * @return mixed 电影名称
     */
    public static function getVideoName($keywords)
    {
//        echo $keywords;
        $re = explode('电影',$keywords);
        return $re[1];
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @param $data 电影的数据内容
     * @return  返回json数据包
     */
    public static function GetVideoMessage($fromusername,$tousername,$videoinfo)
    {
        $data = [
            'touser'=>"$fromusername",
            'template_id'=>'UylxXC0PN49290vIrAec2HcKof6kJWkKKSkKv5KpjJU',
            'url'=>$videoinfo->vurl,
            'data' =>[
                'vname'=>[
                    'value'=>$videoinfo->vname,
                    "color"=>"blue"
                ],
                'vtype'=>[
                    'value'=>$videoinfo->vtype,
                    "color"=>"blue"
                ],
                'vpeople'=>[
                    'value'=>$videoinfo->vpeople,
                    "color"=>"blue"
                ],
                'vdesc'=>[
                    'value'=>$videoinfo->vdesc,
                    "color"=>"blue"
                ],
            ]
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        dd($data);
        $token = json_decode(self::GetAccessToken(),true)['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
        $re = self::HttpPost($url,$data);
        return $re;
    }

    /**
     * @param $keywords 关键字
     * @return mixed 电影名称
     */
    public static function getMusicName($keywords)
    {
//        echo $keywords;
        $re = explode('音乐',$keywords);
        return $re[1];
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @param $data 电影的数据内容
     * @return  返回json数据包
     */
    public static function GetMusicMessage($fromusername,$tousername,$musicinfo)
    {
        $data = [
            'touser'=>"$fromusername",
            'template_id'=>'WBSM1cgLHvkeW091p4WDMp_kF3nbv-KSLwZ6teFJjHY',
            'url'=>$musicinfo->murl,
            'data' =>[
                'mname'=>[
                    'value'=>$musicinfo->mname,
                    "color"=>"blue"
                ],
                'mtype'=>[
                    'value'=>$musicinfo->mtype,
                    "color"=>"blue"
                ],
                'mpeople'=>[
                    'value'=>$musicinfo->mpeople,
                    "color"=>"blue"
                ],
                'mlength'=>[
                    'value'=>$musicinfo->mlength,
                    "color"=>"blue"
                ],
            ]
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $token = json_decode(self::GetAccessToken(),true)['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
        $re = self::HttpPost($url,$data);
        return $re;
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @return string 语音消息模板
     */
    public static function sendVoiceMessage($fromusername,$tousername)
    {
        $res = Subscribe::where(['type'=>'voice'])->orderBy('id','desc')->first();
        $media_id = $res->media_id;
        $time = time();
        $voicespl = "<xml>
                      <ToUserName><![CDATA[$fromusername]]></ToUserName>
                      <FromUserName><![CDATA[$tousername]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[voice]]></MsgType>
                      <Voice>
                        <MediaId><![CDATA[$media_id]]></MediaId>
                      </Voice>
                    </xml>";
        echo $voicespl;die;
    }


    /*
 * @content 图灵机器人
 * */
    /**
     * @param $keywords 关键字
     * @param $url url接口
     * @return mixed 返回获得的数据的内容
     */
    public static function rbot($keywords,$url)
    {
        $data = [
            'reqType'=>0,
            'perception'=>[
                'inputText'=>[
                    'text'=>$keywords,
                ],
            ],
            'userInfo'=>[
                'apiKey'=>'459c874157374cc48b1b3944357f7947',
                'userId'=>'tuling'
            ]
        ];
        $post_data = json_encode($data,JSON_UNESCAPED_UNICODE);
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        $data = json_decode($data,true);
        return $data['results'][0]['values']['text'];
    }

    /**
     * @content  获取群发消息的openid
     * @return mixed 返回openid
     */
    public static function GetOpenIDlist()
    {
        $token = cache('token_');
        if(!$token){
            $token = json_decode(self::GetAccessToken(),true)['access_token'];
            cache(['token_'=>$token],60*24);
        }
        $data = cache('data');
        if(!$data) {
            $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$token";
            $data = file_get_contents($url);
            $data = json_decode($data, true);
            cache(['data'=>$data],60*24);
        }
        $openid = [];
        foreach($data['data']['openid'] as $k=>$v){
            $open['lang'] ="zh_CN";
            $open['openid'] =$v;
            $openid[]=$open;
        }
        $openidinfo = cache('openidinfo');
        if(!$openidinfo) {
            //获取openid相对应的用户基本信息
            $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=$token";
            $data = ['user_list' => $openid];
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $openidinfo = self::HttpPost($url, $data);
            cache(['openidinfo'=>$openidinfo],60*24);
        }
//            dd($openidinfo['user_info_list']);
            $openiduserinfo = [];
            foreach ($openidinfo['user_info_list'] as $k=>$v){
               $info['openid'] = $v['openid'];
               $info['nickname'] = $v['nickname'];
               $info['sex'] = $v['sex'];
               $info['address'] = $v['country'].$v['province'].$v['city'];
               $info['headimgurl'] = $v['headimgurl'];
               $info['subscribe_time'] = $v['subscribe_time'];
                $openiduserinfo[] = $info;
            }
        foreach ($openiduserinfo as $k=>$v){
            $res = Openiduserinfo::where('openid',$v['openid'])->first();
            if(!$res){
                Openiduserinfo::insert($openiduserinfo);
            }
        }
    }

}
