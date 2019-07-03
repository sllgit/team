<?php
namespace libs;

class Log
{
    private static $instance;
    //存放日志目录
    protected $dir = LOG_PATH;

    //存放的数据格式
    protected $format = "[%s]-[%s]:%s\r\n";



    private function __construct()
    {

    }
    
    private function __clone(){

    }
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    public function setFormat($format)
    {
        if($format){
            $this->format = $format;
        }
        return $this;
    }

    public function info($message='')
    {
        $this->checkLogDir();

        //创建文件
        $filename = $this->createFile();
        $message = $this->formatMessage($message);
        file_put_contents($this->dir.DIRECTORY_SEPARATOR.$filename,$message,FILE_APPEND);

    }

    //判断Log文件夹是否存在
    protected function checkLogDir()
    {
        if(!is_dir($this->dir)){
            mkdir($this->dir,0777,true);
        }
    }

    protected function createFile()
    {
        $filename = date("Y-m-d").".log";

        return $filename;
    }

    protected function formatMessage($message)
    {
        return sprintf($this->format,date("Y-m-d"),"info",$message);
    }

}