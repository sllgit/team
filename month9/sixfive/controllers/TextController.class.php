<?php
namespace controllers;

use sixfive\Http;
use sixfive\HttpClient;
use sixfive\Upload;
use api\response;

class TextController{
    public function Index(){


//        $data = [
//            'username'=>'zhangsan',
//            'password'=>123
//        ];
        //生成模拟签名
      var_dump(createSign());die;
//        echo '{"name":"zhangsan","age":"18"}';
//        $array = [
//            'name'=>'sss',
//            'age'=>'12'
//        ];
//        $array = json_encode($array);
//        echo $array;
    }

    public function Http()
    {
        $res = HttpClient::streamHttp("http://www.1810b.com/index.php?c=text&a=post");
//        $res = HttpClient::streamHttp("http://www.1810b.com/index.php?c=text&a=post",["username"=>'zhansan',"password"=>"123456"]);
        if(substr($res['status'][1],0,1) == '2'){
            echo $res['body'];
        }else{
            echo $res['status'][1].":".$res['status'][2];
        }
    }

    public function Post()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
           $upload = new Upload();
           $upload ->setConfig("ext",['jpg','jpeg','png']);
           $upload ->setConfig('mimeType',['image/jpeg','image/jpg','image/png']);
           $res = $upload->uploadOne();
//            var_dump($res);die;
           if (!$res){
                response::gentype(1007,'upload failed',['error'=>$upload->errno()]);
//               echo $upload ->errno();
           }
          response::gentype(1008,'upload successfully',['error'=>$res]);
        }
        include "../views/post.html";
    }

    public function Aa()
    {
        //文件上传
        $file = file_get_contents("./upload/5d022ba8eceecz6yPG.jpg");
        $file = base64_encode($file);
        echo $file;
    }
    //使用CURL 进行文件上传
    public function Curlupload()
    {
        // 使用CURLFile创建一个文件
        $cfile = new \CURLFile('322368.jpg','image/jpeg','322368.jpg');

        $data['file'] = $cfile;
        $res = Http::posthttp("http://www.1810b.com/index.php?c=upload&a=upload",$data,true);
        var_dump($res);
    }
    //从客户端进行文件上传
    public function Curlupload2()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $file = $_FILES['file'];
            //将客户上传的文件提交给我们指定上传接口
            $cfile = new \CURLFile($file['tmp_name'],$file['type'],$file['name']);

            $data['file'] = $cfile;
            $res = Http::posthttp("http://www.1810b.com/index.php?c=upload&a=upload",$data,true);
            var_dump($res);
        }
        require_once "../views/post.html";
    }

    //使用报文 进行文件上传
    public function Curlhttp3()
    {
        //$root = config('database.host');
//        var_dump($root);die;
        $data = "----ABC\r\n";
        $data .= "Content-Disposition:form-data; name=\"username\"\r\n";
        $data .= "\r\n";
        $data .= "zhangsan\r\n";

        $data .= "----ABC\r\n";
        $data .= "Content-Disposition:form-data; name\"file\"; filename=\"322368.jpg\"\r\n";
        $data .= "Content-Type:image/jpeg;\r\n";
        $data .= "\r\n";
        $data .= file_get_contents("./322368.jpg")."\r\n";
        $data .= "----ABC--\r\n";
        $data .= "\r\n";
          //使用fsockopen 进行文件上传
//        $fs = fsockopen("www.1810b.com","80",$errno,$errstr,30);
//
//        $package = "POST /index.php?c=upload&a=upload HTTP/1.1\r\n";
//        $package .= "Host:www.1810b.com\r\n";
//        $package .= "Content-Type:multipart/form-data; boundary=--ABC\r\n";
//        $package .= "Content-Length:".strlen($data)."\r\n";
//        $package .= "\r\n";
//
//        $package .= "$data";
//
//        fwrite($fs,$package);
//        $res = stream_get_contents($fs);
//        var_dump($res);
        //使用封装的fsockopenhttp进行http文件上传
        $res = HttpClient::fsockopenHttp("http://www.1810b.com/index.php?c=upload&a=upload",$data,true);
        var_dump($res);
    }

    public function UploadByQiniu()
    {
      $res = HttpClient::fopenHttp("http://www.1810b.com/index.php?c=upload&a=uploadByQiniu",[
          'filename'=>"322368.jpg",
          'contents'=>base64_encode(file_get_contents('./322368.jpg'))
        ]);
      var_dump($res);
    }

    public function Js()
    {
        $callback = $_GET['callback'];
        $data = '["customername1","customername2"]';
        echo $callback."(".$data.")";
    }
}