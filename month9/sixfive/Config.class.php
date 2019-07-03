<?php
namespace sixfive;

class Config
{
    //单例模式   三私一公
    //私有静态成员  私有克隆方法  私有构造方法  公有静态方法
    private $config = [];

    private static $instance;

    public function __construct($path = '')
    {
        $paths = [
            CONFIG_PATH,
            $path
        ];
        $configs =[];
        //循环得到的这两个路径下的文件
        foreach ($paths as $path){
            $files = $this->getFile($path);
            foreach ($files as $v){
//                var_dump($this->parseFile($v));
                $configs = array_merge($configs,$this->parseFile($v));
            }
        }
//        die;
        $this->config = $configs;
    }

    public static function getInstance()
    {
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function parseFile($filename)
    {
        return parse_ini_file($filename,true);
    }

    public function getFile($dir)
    {
        $files = [];
        if(is_dir($dir)){
            if (($fd = opendir($dir)) !== false){
                while (($file= readdir($fd)) != false){
                    $path = $dir.DIRECTORY_SEPARATOR.$file;
                    if($file != '.' && $file != '..'){
                        if(is_dir($path)){
                            $fil= $this->getFile($path);
                            foreach ($fil as $v){
                                $files[] = $v;
                            }
                        }else{
                            $files[] = $path;
                        }
                    }
                }
            }
        }
        return $files;
    }

    private function __clone()
    {

    }

    public function setConfig($name,$value)
    {
        if($name){
            $key = '';
            $name = explode('.',$name);
            if(count($name) == 1 || $name[1] == ""){
                $key = $name[0];
                $this->config[$key] = $value;
            }else{
                $this->config[$name[0]][$name[1]] = $value;
            }
        }
    }

    public function getConfig($name='')
    {
        if($name){
            $key = '';
            $name = explode('.',$name);
            if(count($name) == 1 || $name[1] == ""){
                $key = $name[0];
                return isset($this->config[$key]) ? $this->config[$key] : null;
            }
            return isset($this->config[$name[0]][$name[1]]) ? $this->config[$name[0]][$name[1]] : null;
        }
        return $this->config;
    }


}