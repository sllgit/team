<?php
namespace api;
class Route{
    private $controller = "index";
    private $action = "index";

    public function routeParse()
    {
        //c表示控制器  后缀controller   a表示方法名
        list($c,$a) = $this->getRoute();

        //如果$a $c 不为空 则为默认的值index
        $c !=="" && $this->controller = $c;
        $a !=="" && $this->action = $a;
//        var_dump($c);die;
        //返回控制器和方法
        $this->controller = ucfirst($this->controller)."Controller";
        $this->action = ucfirst($this->action);

        return [$this->controller,$this->action];
    }

    public function getRoute()
    {
        //var_dump($_SERVER);
        $controller = '';
        $action = '';
        //直接通过地址栏中的参数c和a获取相应的控制器和方法
        list($controller,$action)  = $this->getRouteByUrl();

        //通过pathinfo获取  www.1810b.com/index.php/font/student
        $controller || $action || list($controller,$action)  =  $this->getRouteByPathInfo();

        //通过正则来获取  www.1810b.com/font/students?s=112
        $controller || $action || list($controller,$action)  =  $this->getRouteByUri();

        //通过通用规则获取  www.1810b.com/font/student/x/1/y/1?z=23&m=34
        $controller || $action || list($controller,$action)  =  $this->getRouteByParams();

        return [$controller,$action];
    }

    protected function getRouteByUrl()
    {
        $controller = request()->get('c','');
        $action = request()->get('a','');

        return [$controller,$action];
    }

    protected function getRouteByPathInfo()
    {
        $controller = '';
        $action = '';

        $pathinfo = $_SERVER['PATH_INFO'] ?? "";

        if($pathinfo){
           $path = explode('/',$pathinfo);
           $controller = $path[1] ?? '';
           $action = $path[2] ?? '';
           for ($i=3;$i<count($path);$i=$i+2){
               $_GET[$path[$i]] = $path[$i+1];
           }
           return [$controller,$action];
        }
    }

    public function getRouteByUri()
    {
        $controller = '';
        $action = '';

        $uri = $_SERVER['REQUEST_URI'];

        //进行正则匹配
        $regs = $this->regForRoute();
        foreach ($regs as $reg=>$replace){
            if(preg_match($reg,$uri)){
               $newUri = preg_replace($reg,$replace,$uri);
               //将字符串进行处理
                $params = explode('&',$newUri);
                foreach ($params as $param){
                    $p = explode('=',$param);
                    if($p[0] == 'c'){
                        $controller = $p[1];
                    }elseif($p[0] == 'a'){
                        $action = $p[1];
                    }else{
                        $_GET[$p[0]] = $p[1];
                    }
                }
              break;
            }
        }

        return [$controller,$action];
    }

    protected function getRouteByParams()
    {
        $controller = '';
        $action = '';

        $uri = $_SERVER['REDIRECT_URL'];
        $uri = explode('?',$uri);
        //处理？之后的部分
        if(isset($uri[1])){
            $params = explode('&',$uri[1]);
            foreach ($params as $v){
                $v = explode('=',$v);
                $_GET[$v[0]] = $v[1];
            }
        }
        //处理？之前的部分
        $path = explode('/',$uri[0]);
        $controller = $path[1] ?? '';
        $action = $path[2] ?? '';
        for ($i=3;$i<count($path);$i+=2){
            $_GET[$path[$i]] = $path[$i+1] ?? '';
        }
        return [$controller,$action];
    }

    protected function regForRoute()
    {
        return [
            //有数字的情况
            "#^/(\w+)/(\d+)\?(.*)$#" => "c=$1&a=index&id=$2&$3",
            "#^/(\w+)/(\d+)$#" => "c=$1&a=index&id=$2",
            "#^/(\w+)/(\w+)\?(.*)$#" => "c=$1&a=$2&$3",
            "#^/(\w+)/(\w+)$#" => "c=$1&a=$2",
            "#^/(\w+)$#" => "c=$1&a=index",
            "#^/(\w+)\?(.*)$#" => "c=$1&a=index&$2",

        ];
    }
}