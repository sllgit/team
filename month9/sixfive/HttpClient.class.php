<?php

namespace sixfive;

class HttpClient
{
    //使用fopen实现get POST请求
    public static function fopenHttp($url,$data='')
    {
        $ops = [];
        if(is_array($data) && !empty($data)){
            //进行POST请求
            $data = http_build_query($data);
            $ops = array(
                'http'=>array(
                    'method'=>"POST",
                    'header'=>"Content-Type:application/x-www-form-urlencoded\r\n".
                        "Content-Length:".strlen($data)."\r\n",
                    'content'=>$data
                )
            );
        }
        $context = stream_context_create($ops);
        $fp = fopen($url,'r',false,$context);
        //读取结果
        $content = stream_get_contents($fp);
        return $content;
    }

    //使用file实现get POST 请求
    public static function fileHttp($url,$data='')
    {
        $ops = [];
        if(is_array($data) && !empty($data)){
            //进行POST请求
            $data = http_build_query($data);
            $ops = array(
                'http'=>array(
                    'method'=>"POST",
                    'header'=>"Content-Type:application/x-www-form-urlencoded\r\n".
                        "Content-Length:".strlen($data)."\r\n",
                    'content'=>$data
                )
            );
        }
        $context = stream_context_create($ops);
        $content = file($url,0,$context);
        //读取结果
        $content = implode("\r\n",$content);
        return $content;
    }

    // 第三种使用file_get_contents实现http请求
    public static function fileGetContentHttp($url,$data='')
    {
        $ops = [];
        if(is_array($data) && !empty($data)){
            //进行POST请求
            $data = http_build_query($data);
            $ops = array(
                'http'=>array(
                    'method'=>"POST",
                    'header'=>"Content-Type:application/x-www-form-urlencoded\r\n".
                        "Content-Length:".strlen($data)."\r\n",
                    'content'=>$data
                )
            );
        }
        $context = stream_context_create($ops);
        $content = file_get_contents($url,false,$context);

        return $content;
    }

    //使用fsockopen实现get POST 请求
    public static function fsockopenHttp($url,$data='',$multipart=false,$port=80)
    {
        $method = "GET";
        $parameter = parse_url($url);

        $path = $parameter['path'] ?? '/';
        if(isset($parameter['query'])){
            $path .= '?'.$parameter['query'];
        }
        //打开连接
        $fp = fsockopen($parameter['host'],$port,$errno,$errstr,30);
        if(!$fp){
            //抛出错误信息
        }
        //编写HTTP报文
        $httpStr = "GET ".$path."?".$parameter['query']." HTTP/1.1\r\n";
        if(is_array($data) && !empty($data)){
            $method = "POST";
            $httpStr = "POST ".$path."?".$parameter['query']." HTTP/1.1\r\n";
            //进行POST请求
            $multipart || $data = http_build_query($data);
            $httpStr .= "Content-Length: ".strlen($data)."\r\n";
            $httpStr .= $multipart ? "Content-Type: multipart/form-data\r\n" :"Content-Type: application/x-www-form-urlencoded\r\n";
        }
        $httpStr .= "Host: ".$parameter['host']."\r\n";
        $httpStr .= "Accept: */*\r\n";
        $httpStr .= "\r\n";

        if($method == "POST"){
            $httpStr .= $data;
        }
        //发送请求
        fwrite($fp,$httpStr);
        //接收响应
        $content = stream_get_contents($fp);
//        var_dump($content);die;
        return self::parsehttp($content);
    }

    //使用tcp实现get POST 请求
    public static function streamHttp($url,$data='',$port=80)
    {
        $method = "GET";
        $parameter = parse_url($url);

        $path = $parameter['path'] ?? '/';
        if(isset($parameter['query'])){
            $path .= '?'.$parameter['query'];
        }
        //打开连接
        $fs = stream_socket_client("tcp://".$parameter['host'].":".$port,$errno,$errstr,30);
        if(!$fs){
            //抛出错误信息
        }
        //编写HTTP报文
        $httpStr = "GET ".$path."?".$parameter['query']." HTTP/1.1\r\n";
        if(is_array($data) && !empty($data)){
            $method = "POST";
            $httpStr = "POST ".$path."?".$parameter['query']." HTTP/1.1\r\n";
            //进行POST请求
            $data = http_build_query($data);
            $httpStr .= "Content-Length: ".strlen($data)."\r\n";
            $httpStr .= "Content-Type: application/x-www-form-urlencoded\r\n";
        }
        $httpStr .= "Host: ".$parameter['host']."\r\n";
        $httpStr .= "Accept: */*\r\n";
        $httpStr .= "\r\n";

        if($method == "POST"){
            $httpStr .= $data;
        }
        //发送请求
        fwrite($fs,$httpStr);
        //接收响应
        $content = stream_get_contents($fs);
        return self::parsehttp($content);
    }

    //解析响应报文
    protected static function parsehttp($content='')
    {
        //按照空行分割得到的报文头部和报文实体
        list($http_header,$http_body) = explode("\r\n\r\n",$content);
//        var_dump($http_header);
        //得到起始行
        $http_header = explode("\r\n",$http_header);

        //得到起始行的各个参数
        list($schema,$code,$codeInfo) = explode(" ", $http_header[0]);
        // 删除起始行
        unset($http_header[0]);

        $headers = [];
        //把请求头的内容 转化为数组的形式
        foreach($http_header as $v){
            list($key,$value)=explode(": ", $v);
            $headers[$key] = $value;
        }

        //得到内容
        $body = '';
        //判断是否是 分块解析
        if(isset($headers['Transfer-Encoding'])){
            while($http_body){
                //转化为数组  0 => chunk大小 1 => chunk数据体
                $httpBody = explode("\r\n",$http_body,2);
                //把chunk大小转化为16进制格式大小
                $chunkedSize = intval($httpBody[0],16);
                //从数据体中截取chunk大小的数据 拼接起来
                $body .= substr($httpBody[1], 0,$chunkedSize);
                //将http_body重新赋值为 截取后的 两个字符后的 数据
                $http_body = substr($http_body[1],$chunkedSize+2);
            }
        }else{
            $body = $http_body;
        }
        return [
            'status'=>[$schema,$code,$codeInfo],
            'header'=>$headers,
            'body'=>$body
        ];
    }
}