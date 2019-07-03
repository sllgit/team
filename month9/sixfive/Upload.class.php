<?php
namespace sixfive;

use api\response;

class Upload
{
    public $errno = 0;
    protected $config = [
        'ext' => [],
        'mimeType' => [],
        'size' => -1,
        'savePath' => './upload',
        'transferBybase64'=>false
    ];

    public function __construct($config = [])
    {
        return $this->config = array_merge($this->config,$config);
    }
    //设置单个项
    public function setConfig($name,$value)
    {
         $this->config[$name]=$value;
    }
    //读取参数项
    public function getConfig($name)
    {
        return $this->config[$name];
    }

    //上传单个文件
    public function uploadOne()
    {
        foreach ($_FILES as $v){
            $file = $v;
        }
       return $this->upload($file);

    }

    //基于base64 上传的方式
    public function uploadByStream($name,$size,$file)
    {
        //判断上传文件大小是否符合
        if(!$this->checkSize($size)){
            $this->errno = 8;
            return;
        }
        //判断上传文件后缀是否符合
        if(!$this->checkExt($name)){
            $this->errno = 9;
            return;
        }

        //判断上传目录是都存在 不存在创建
        $this->checkUploadDir();

        //将临时文件夹移动到规定文件夹下
        $filename = $this->newFileName($name);//新目录

        file_put_contents($this->config['savePath'].DIRECTORY_SEPARATOR.$filename,base64_decode($file));

        //返回数据 name size
        $result = [
            'name' => $name,
            'size' => $size,
            'savePath' => $this->config['savePath'],
            'filename' => $filename
        ];
        return $result;
    }
    //上传多个文件
    public function uploadAll()
    {
        $results =[];
        foreach ($_FILES as $v){
            $files = $v;
        }
//        var_dump($files);die;
        foreach ($files['name'] as $k=>$v){
            $file = [
                'name' =>$v,
                'tmp_name'=>$files['tmp_name'][$k],
                'type'=>$files['type'][$k],
                'error'=>$files['error'][$k],
                'size'=>$files['size'][$k]
            ];
            $result = $this->upload($file);
            if(!$result){
                continue;//错误跳过该执行
            }
            array_push($results,$result);
        }
        return $results;

    }
    //上传的核心文件
    public function upload($file = [])
    {
        //判断文件是否出现错误
        if($file['error']){
            $this->errno = $file['error'];
            return;
        }

        //判断上传文件大小是否符合
        if(!$this->checkSize($file['size'])){
            $this->errno = 8;
            return;
        }
        //判断上传文件后缀是否符合
        if(!$this->checkExt($file['name'])){
            $this->errno = 9;
            return;
        }

        //判断上传文件类型是否符合
        if(!$this->checkType($file['tmp_name'],$file['type'])){
            $this->errno = 10;
            return;
        }

        //判断上传目录是都存在 不存在创建
        $this->checkUploadDir();

        //将临时文件夹移动到规定文件夹下
        $filename = $this->newFileName($file['name']);//新的目录
        //判断文件是否通过http POST上传的
        if (!is_uploaded_file($file['tmp_name'])){
            $this->errno = 12;
            return;
        }
        move_uploaded_file($file['tmp_name'],$this->config['savePath'].DIRECTORY_SEPARATOR.$filename);
        //返回数据 name size
        $result = [
            'name' => $file['name'],
            'size' => $file['size'],
            'savePath' => $this->config['savePath'],
            'filename' => $filename
        ];
        return $result;

    }

    //判断文件上传后缀
    protected function checkExt($ext)
    {
       $ext = $this->getExt($ext);
       //判断文件后缀是否在定义的数组里
       return in_array($ext,$this->config['ext']);
    }
    //获取文件后缀
    public function getExt($ext)
    {
        //返回文件路径的后缀 jpeg
        return  pathinfo($ext,PATHINFO_EXTENSION );
    }


    //判断文件上传的大小
    protected function checkSize($size)
    {
        if($size == -1){
            return true;
        }
//        var_dump($size);die;
       return $this->config['size'] > $size ? false : true ;
    }

    //判断上传的类型
    public function checkType($name,$type)
    {
        //最好的方式是直接通过函数获取真实文件的mime类型
        $mime = mime_content_type($name);
        //判断文件的真实类型是否和定义的类型相等
        if($mime == $type){
            return in_array($type,$this->config['mimeType']);
        }
        return false;
    }
    //文件是否存在
    public function checkUploadDir()
    {
        //判断定义的是否为目录且是否存在
        if(!is_dir($this->config['savePath'])){
            //创建目录 是否成功
            if(!mkdir($this->config['savePath'],0777,true)){
                $this->errno = 11;
                return;
            }
        }
    }

    //新的目录下
    public function newFileName($name)
    {
        $ext = $this->getExt($name);
        return uniqid().createRendstring(5).'.'.$ext;
    }

    //上传文件的错误信息
    public function errno($errno = '')
    {
        $errno = $errno ? $errno : $this->errno;
        $errstr = '';
        switch ($errno)
        {
            case UPLOAD_ERR_CANT_WRITE:
                $errstr = "文件写入失败";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errstr = "找不到临时文件夹";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errstr = "没有文件被上传";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errstr = "上传文件大小超过了MAX_FILE_SIZE 限定的值";
                break;
            case UPLOAD_ERR_INI_SIZE:
                $errstr = "上传文件超过了PHP限定的值";
                break;
            case 8:
                $errstr = "上传文件大小不符合";
                break;
            case 9:
                $errstr = "上传文件后缀不符合";
                break;
            case 10:
                $errstr = "上传文件类型不符合";
                break;
            case 11:
                $errstr = "创建文件失败";
                break;
            case 12:
                $errstr = "非正常文件";
                break;
            case UPLOAD_ERR_OK:

                break;
        }
        return $errstr;
    }
}