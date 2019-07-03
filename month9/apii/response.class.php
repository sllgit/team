<?php
namespace apii;

class response
{
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

        return json_encode($dt,JSON_UNESCAPED_UNICODE);

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

}