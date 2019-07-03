<?php
namespace controllers;

use models\UserModel;
use sixfive\Http;
class ExamController extends UserCommonController
{
    public function Userverify()
    {
        $model = new UserModel();
        $token = $model->createToken(1);
        var_dump($token);
    }

    public function Find()
    {
        //文章查询接口
        require_once "../views/select.html";
    }

    public function selectposthttp()
    {
        $table = $_REQUEST['table'];
        $table = array("table"=>"$table");
        $url = "http://localhost/month9/sixfive/exam/select.php";
        Http::posthttp($url,$table);
    }
    //文章内容显示
    public function Contentshow()
    {
        require_once "../views/contentshow.html";
    }
    public function Contentshowposthttp()
    {
        $title = $_REQUEST['title'];
        $table = array("title"=>"$title");
        $url = "http://localhost/month9/sixfive/exam/contentshow.php";
        Http::posthttp($url,$table);
    }
}