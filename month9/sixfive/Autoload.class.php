<?php

namespace sixfive;

use api\response;
use Couchbase\Exception;
use libs\Log;


class Autoload
{
    public function __construct()
    {
        //注册一个自动加载类
        spl_autoload_register([$this,'_autoload']);

        //加载函数
        $this->loadFuns();

        //注册异常处理机制
        //set_exception_handler([$this,"exceptionHandler"]);
        //set_error_handler([$this,"errorHandler"]);
        //register_shutdown_function([$this,"shutdownHandler"]);
    }
    //自动加载
    public function _autoload($className)
    {
        //加载以什么结尾的文件
        $ext = ".class.php";
        //把‘\’替换成 ‘/’使得在nginx、线上中都能解析
        $file = str_replace('\\',DIRECTORY_SEPARATOR,$className).$ext;
        //找到路径
        $file = APP_PATH.DIRECTORY_SEPARATOR."../".$file;
        //判断是否存在 存在则包含该文件
        if(file_exists($file)){
            require_once $file;
        }
    }

    //自动加载函数库
    public function loadFuns($path='')
    {
        $paths = [
            FUNC_PATH,
            $path
        ];
        foreach ($paths as $path){
//            var_dump($path);
            //遍历函数库文件夹 判断
            if($path && is_dir($path)){
                if($dir = opendir($path)){
                    while(($file = readdir($dir)) != false){
                        if($file != '.' && $file != '..'){
                            include $path.DIRECTORY_SEPARATOR.$file;
                        }
                    }
                }
            }
        }
    }

    public function exceptionHandler(\Exception $exception)
    {
        $message = $exception->getMessage()." in ".$exception->getFile()." on line ".$exception->getLine();
//        var_dump($message);die;

        //原生日志
        Log::getInstance()->setDir(__DIR__."/../logs/customlog")->setFormat("[time: %s][level: %s][info: %s]")->info($message);
        //发送邮件
        //Log::getInstance()->info($message);
        // 创建Transport对象，设置邮件服务器和端口号，并设置用户名和密码以供验证
        $transport = (new \Swift_SmtpTransport(config("mailer.server"),config("mailer.port")))
            ->setUsername(config("mailer.username"))
            ->setPassword(config("mailer.password"));

        // 创建mailer对象
        $mailer = new \Swift_Mailer($transport);
        // 创建message对象
        $msg = new \Swift_Message("系统出错了");
        $msg->setFrom(['1477380279@qq.com'=>"sll"])
            ->setTo(['1477380279@qq.com'])
            ->setBody(
                '<html>'.
                '<head></head>'.
                '<body>'.
                '<h1>系统出错了</h1>'.
                '<p>'.
                $message.
                '</p>'.
                '</body>'.
                '</html>'
                ,'text/html'
            );


        // 发送邮件
        $result = $mailer->send($msg);




        //response::gentype(500,'Interal ERROR');

        //monolog日志
        //setLog("myapp",$message);
    }

    public function errorHandler($errno,$errstr,$errfile,$errline)
    {
        //原生日志
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        //monolog日志
        //setLog("myapp",$errfile.":".$errline."-".$errno."[{$errstr}]");
    }

    public function shutdownHandler()
    {
        //                   获取最后发生的错误
        if(!is_null($error = error_get_last()) && $this->isFatal($error['type'])){
            $this->exceptionHandler(new \ErrorException( $error['message'],$error['type'],0,$error['file'],$error['line']));
        }
    }

    protected function isFatal($type)
    {

        return in_array($type,[E_COMPILE_ERROR,E_CORE_ERROR,E_ERROR,E_PARSE]);
    }

}

new Autoload();