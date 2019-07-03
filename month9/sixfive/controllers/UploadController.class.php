<?php
namespace controllers;

use api\response;
use sixfive\Upload;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

class UploadController
{
    //普通的multipart/form-data方式上传
    public function Upload()
    {
//        var_dump($_FILES);die;
//        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $upload = new Upload();
            $upload ->setConfig("ext",['jpg','jpeg','png']);
            $upload ->setConfig('mimeType',['image/jpeg','image/jpg','image/png']);
            //单文件上传
//            $res = $upload->uploadOne();
            //多文件上传
            $res = $upload->uploadAll();
//            var_dump($res);die;
            if (!$res){
                response::gentype(1007,'upload failed',['error'=>$upload->errno()]);
            }
            response::gentype(1008,'upload successfully',$res);
//        }
//        include "../views/post.html";
    }
    //使用base64方式上传
    public function uploadByBase64()
    {
        $file = $_POST['file'];
        $name = $_POST['name'];
        $size = $_POST['size'];

        $upload = new Upload();
        $upload ->setConfig("ext",['jpg','jpeg','png']);
        $upload ->setConfig('mimeType',['image/jpeg','image/jpg','image/png']);
        $res = $upload->uploadByStream($name,$size,$file);
        if (!$res){
                response::gentype(1007,'upload failed',['error'=>$upload->errno()]);
        }
        response::gentype(1008,'upload successfully',['error'=>$res]);
    }

    public function UploadByStream()
    {
        $file = file_get_contents("php://input");
        file_put_contents("./upload/a.jpg",$file);
    }

    public function Json()
    {
        $file = file_get_contents("php://input");
        var_dump($file);
    }

    public function uploads()
    {
        $upload = new Upload();
        $upload ->setConfig("ext",['jpg','jpeg','png']);
        $upload ->setConfig('mimeType',['image/jpeg','image/jpg','image/png']);
        //单文件上传
            $res = $upload->uploadOne();
        //多文件上传
//        $res = $upload->uploadAll();
//            var_dump($res);die;
        if (!$res){
            response::gentype(1007,'upload failed',['error'=>$upload->errno()]);
        }
        response::gentype(1008,'upload successfully',$res);
    }

    //七牛云上传图片
    public function UploadByQiniu()
    {
        $file_name = $_POST['filename'];
        $file_contents = base64_decode($_POST['contents']);

        $accessKey = config('Qiniu.accessKey');
        $secretKey = config('Qiniu.secretKey');
        $bucketName = config('Qiniu.bucketName');
//        var_dump($secretKey);die;
        $domain = config('Qiniu.domain');

        $auth = new Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucketName);

        $upManager = new UploadManager();
        list($ret, $error) = $upManager->put($token, $file_name, $file_contents);
        if($error){
            Response::gentype(500,"INNER ERROR");
        }
        Response::gentype(200,'OK',['path'=>$domain."/".$ret['key']]);
    }


}