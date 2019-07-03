<?php
header("Access-Control-Allow-origin: http://www.1810.com");
header("Access-Contorl-Allow-Method: * ");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Content-Length,Accept,Accept-Encoding,Host,Referer,x-api-token");
header("Access-Control-Expose-Headers: Referer");

//定义各种常量
define("APP_PATH",__DIR__);
define("FUNC_PATH",__DIR__.'/../functions');
define("CONFIG_PATH",__DIR__.'/../config');
define("LOG_PATH",__DIR__.'/../Log');

//自动加载类
require_once "../Autoload.class.php";
require_once "../vendor/autoload.php";
require_once "../http.class.php";
require_once "../HttpClient.class.php";
require_once "../Upload.class.php";
require_once "../Config.class.php";


ini_set("display_errors","On");
ini_set("log_errors","On");
ini_set("error_log",__DIR__."/../logs/error.log");

//路由
$arr=new \api\Route();
list($controller,$action)=$arr->routeParse();
//实例化控制器
$controller="controllers\\".$controller;
(new $controller)->$action();