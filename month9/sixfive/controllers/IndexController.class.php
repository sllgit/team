<?php
namespace controllers;
use models\UserModel;

class IndexController
{
    public function Indexs()
    {
        $model = new UserModel();
        $res = $model->query("select * from __table__");
        var_dump($res);

    }

    public function Index()
    {
//        require_once "../views/index.html";
//        require_once "../views/uploads.html";
        require_once "../views/uploadchunkss.html";
    }

    public function Upload()
    {
            $file = $_FILES['file'];
            $filename = $file['name'];//分片的名称
            $names = $_REQUEST['names'];//文件的名称

            //检测public/upload目录是否存在  不存在创建
            if (!file_exists("upload")){
                mkdir("upload");
            }

            //将临时目录移动到public/upload目录下 以传来的分片的名称命名
            $filename = "upload/".$filename;
            move_uploaded_file($file['tmp_name'],$filename);

            //把文件读入一个字符串中
            $ress = file_get_contents($filename);

            //把读取的字符串追加到以文件名命名的文件中
            file_put_contents("upload"."/".$names,$ress,FILE_APPEND);

            //删除分片的文件
            @unlink($filename);


        }
}
