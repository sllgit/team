<?php

//专门用来得到客户端传递过多来的数据

class Request
{
    protected $headers = [];

    public function __construct()
    {
        $this->getHeader();
    }

    public function getHeader()
    {
        $headers = [];

        isset($_SERVER['CONTENT_TYPE']) && $headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
        isset($_SERVER['CONTENT_LENGTH']) && $headers['Content-Length'] = $_SERVER['CONTENT_LENGTH'];

        foreach ($_SERVER as $key=>$v){
            if(strpos($key,"HTTP_") === 0){
                $k = $this->updHeader($key);
                if($k == 'Authorization'){
                    $v = str_replace("Bearer ", '',$v);
                }
                $headers[$k] = $v;
            }
        }
        $this->header = $headers;
    }

    protected function updHeader($key){
        $k = str_replace("HTTP_",'',$key);
        $k = explode("_",$k);
        $k = array_map(function ($v){
            return ucfirst(strtolower($v));
        }, $k);
        $k = implode('-',$k);
        return $k;
    }

    //获取所有元素
    public function all($name = '',$default = '')
    {
        parse_str(file_get_contents("php://input"),$data);
           $request = $_GET + $_POST + $data;
           if($name){
               return isset($request[$name]) ? $request[$name] : $default;
           }
           return $request;
    }

    //返回出某些元素外的其他所有元素
    public function except($expect = [])
    {
        $data = $this->all();
        if(is_array($expect)){
            foreach ($expect as $v){
                unset($data[$v]);
            }
        }else if($expect != ''){
            unset($data[$expect]);
        }
        return $data;
    }

    public function get($name='',$default='')
    {
       if($name){
           return isset($_GET[$name]) ? $_GET[$name] : $default;
       }
       return $_GET;
    }

    public function post($name='',$default='')
    {
        if($name){
            return isset($_POST[$name]) ? $_POST[$name] : $default;;
        }
        return $_POST;
    }

    public function header($name=""){
        if($name){
            return $this->headers[$name] ?? null;
        }
        return $this->headers;
    }
}