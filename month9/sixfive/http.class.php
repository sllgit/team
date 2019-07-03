<?php

namespace sixfive;

class Http
{
    //post 请求
    public static function posthttp($url='',$data=[],$multipart=false,$headers=[])
    {
        if(!$multipart){
            $data = http_build_query($data);
        }
        $options = [
            CURLOPT_URL=>$url,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$data
        ];
        if($headers){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        if(self::isHttps($url)){
            $options[CURLOPT_SSL_VERIFYHOST]=false;
            $options[CURLOPT_SSL_VERIFYPEER]=false;
        }
        return self::dohttp($options);

    }

    //get 请求
    public static function getHttp($url='',$headers=[])
    {
        $options = [
            CURLOPT_URL=>$url
        ];
        if(self::isHttps($url)){
            $options[CURLOPT_SSL_VERIFYHOST]=false;
            $options[CURLOPT_SSL_VERIFYPEER]=false;
        }
        if($headers){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        return self::dohttp($options);
    }
    //判断是否为https请求
    public static function isHttps($url)
    {
        if(strpos($url,'https://') == 0){
            return true;
        }
        return false;
    }

    //
    public static function dohttp($options=[])
    {
        $option = [
            CURLOPT_FOLLOWLOCATION=>true,
            CURLOPT_RETURNTRANSFER=>true,
        ];
        $option = $option + $options;
//        var_dump($option);die;
        $http = curl_init();
        //为cURL传输会话批量设置选项
        curl_setopt_array($http,$options);

        $result = curl_exec($http);
        if(!$result){
            $result = curl_error($http);
        }

        curl_close($http);
        return $result;
    }
}
