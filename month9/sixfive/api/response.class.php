<?php
namespace api;

class response
{

    public static function setResponseHeader($code='',$contentType)
    {
        header("HTTP/1.1 $code ".self::getHttpStatusMessage($code));
        header("Content-Type: {$contentType}");
    }

    public static function restfulResponse($code,$message,$data=[])
    {
        $contentType = request()->header("Accept") ? : "application/json";
        //设置相应的header头
        self::setResponseHeader($code,$contentType);

        switch ($contentType){
            case "text/html":

                break;
            case "text/xml":
            case "application/xml":

                break;
            default:
                $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        die($data);
    }

    //选择返回的数剧类型
    public static function gentype($code,$message,$data=[])
    {
        $res = '';

        $type = isset($_GET['type']) ? trim($_GET['type']) : 'json';

        switch ($type){
            case "array":
               $res =  self::arrays($code,$message,$data);
               break;
            case "xml":
                $res = self::xml($code,$message,$data);
                break;
            default :
                $res = self::json($code,$message,$data);
        }
        if(is_array($res)) {
            var_dump($res);die;
        }
        exit($res);
    }

    //生成通用的相应数组
    public static function arrays($code,$message,$data=[])
    {
        return [
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ];
    }

    //响应json类型的数据
    public static function json($code,$message,$data=[])
    {
        $dt = self::arrays($code,$message,$data);

        return json_encode($dt,JSON_UNESCAPED_UNICODE);die;

    }

    //响应xml格式的数据
    public static function xml($code,$message,$data=[])
    {
//        var_dump($data);die;
        $xml = "<?xml version='1.0' encoding='utf-8'?>";

        $xml .= "<root>";

        $xml .= "<code>".$code."</code>";

        $xml .= "<message>".$message."</message>";

        $xml .= "<data>";

        $xml .= self::dataxml($data['data']);

        $xml .= "</data>";

        $xml .="</root>";

        return $xml;
    }

    //根据data生成xml对象
    private static function dataxml($data)
    {
        $xml = '';
        foreach ($data as $k => $v){
            if(is_array($v)){
                $xml .= "<{$k}>";
                $xml .= self::dataxml($v);
                $xml .= "</{$k}>";
            }else{
                $xml .= "<{$k}>{$v}</{$k}>";
            }
        }
        return $xml;
    }

    public static function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
    }

}