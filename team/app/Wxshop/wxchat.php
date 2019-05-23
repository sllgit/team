<?php

namespace App\Wxshop;

use Illuminate\Database\Eloquent\Model;
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


}
