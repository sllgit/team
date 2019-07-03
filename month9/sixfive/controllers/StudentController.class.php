<?php
namespace controllers;
use api\response;
use models\StudentModel;

class StudentController extends RestfulController
{
    //查询
    public function lists()
    {
        $model = new StudentModel();
        $data = $model ->query("select * from __table__ ");
        response::restfulResponse(200,'ok',$data);
        //var_dump($data);
    }

    //添加
    public function store()
    {
        $data = request()->post();
        $model = new StudentModel();
        if($model ->exec("insert into __table__ set name=:name,sex=:sex,age=:age",$data)){
            response::restfulResponse(200,'ok',$data);
        }else{
            response::restfulResponse(201,'','添加成功');
        }
       
    }

    //修改
    public function save()
    {
       $data = request()->all();
       $id = request()->get('id');
       $data['id'] = $id;
       $model = new StudentModel();
       $re = $model->query("select * from __table__ where id=?",[$id]);

        if(!$re){
           response::restfulResponse(404,'',['error'=>"NOT FOUND"]);
       }
        $res = $model->exec("update __table__ set name=?,sex=?,age=? where id=?",[$data['name'],$data['sex'],$data['age'],$id]);
       if(!$res){
           response::restfulResponse(417,'',['error'=>"修改失败"]);
       }
       $student['name'] = $data['name'];
       $student['sex'] = $data['sex'];
       $student['age'] = $data['age'];
       response::restfulResponse(200,'ok',$student);
    }

    //删除
    public function delete()
    {
        $id = request()->get('id');

        $model = new StudentModel();
        $re = $model->query("select * from __table__ where id=?",[$id]);

        if(!$re){
            response::restfulResponse(404,'',['error'=>"NOT FOUND"]);
        }
        $res = $model->exec("delete from __table__ where id=?",[$id]);
        if($res){
            response::restfulResponse(204,'',[]);
        }
        //response::restfulResponse(500,'',['error'=>"内部错误"]);
    }
}