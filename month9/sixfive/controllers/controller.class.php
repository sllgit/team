<?php
namespace controllers;

use api\response;

class Controller
{
    //省份认证 + 数据安全保护 = 签名

    protected $key = "1810b";

    protected $noncestr = '';
    protected $timestamp = '';
    protected $signature = '';

    public function __construct()
    {

        $this->checksign();
    }

    //get签名验证
    public function checksign()
    {

        //获取随机数
        $noncestr = request()->all('noncestr');
        //获取时间戳
        $timestamp = request()->all('timestamp');
        //获取客户传递过来的签名
        $signature = request()->all('sign');
//        dd($signature);
        $noncestr && $this->noncestr = $noncestr;
        $timestamp && $this->timestamp = $timestamp;
        $signature && $this->signature = $signature;

        if(!$this->noncestr || !$this->timestamp || !$this->signature){
            response::gentype(400,'Bad Request');
        }

        if($this->timestamp + 60 < time()){
            response::gentype(1009,'EXPIRE Signature');
        }
        $this->compareSign();
   }
   //验证签名是否正确
   protected function compareSign()
   {
       //获取所有参数
       $all = request()->except(['c','a','sign','usertoken','username','password']);
       //生成一个数组
       $signArr = ['timestamp'=>$this->timestamp,'noncestr'=>$this->noncestr,'key'=>$this->key];
       $signArr = $signArr + $all;
       //进行字典排序
       sort($signArr,SORT_STRING);
      $signature = sha1(implode($signArr));
//      dd($all);
      if($this->signature !== $signature){
          response::gentype(1001,'Signature UnAutorization');
      }

   }
}
