<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video;
class VideoController extends Controller
{
    /**
     * @content 电影添加 及添加执行
     */
    public function addvideo()
    {
        if(\request()->Post()){
//            dd(\request()->all());
            $data = \request()->all();
            if($data['vtype'] == '0'){
                echo "<script>alert('类型不能为空');location.href='/admin/addvideo'</script>";
            }
            $res = Video::insert($data);
            if($res){
                echo "<script>alert('添加成功');location.href='/admin/videolist'</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/admin/addvideo'</script>";
            }
        }else{
            return view('admin.addvideo');
        }

    }

    /**
     * @content 电影列表
     */
    public function videolist()
    {
        $request = request()->all();
        $where = [];
        $vname = $_GET['vname']??'';
        if($vname){
            $where[] = ['vname','like',"%$vname%"];
        }
        $vtype = $_GET['vtype']??'';
        if($vtype){
            $where[] = ['vtype','=',"$vtype"];
        }
        $data = Video::where('vstatus',1)->where($where)->paginate(3);
        return view('admin.videolist',compact('data','request','vname','vtype'));
    }

    /**
     * @content 电影列表修改
     */
    public function videoupd($id)
    {
        $data = Video::where('vid',$id)->first()->toArray();
        return view('admin/updvideo',compact('data'));
    }

    /**
     * @content 电影列表修执行
     */
    public function videoupddo()
    {
        $data = \request()->all();
        if($data['vtype'] == '0'){
            echo "<script>alert('类型不能为空');location.href='/admin/videolist'</script>";
        }
        $res = Video::where('vid',$data['vid'])->update($data);
        if($res){
            echo "<script>alert('修改成功');location.href='/admin/videolist'</script>";
        }else{
            echo "<script>alert('修改失败');location.href='/admin/videolist'</script>";
        }
    }

    /**
     * @content 电影列表删除
     */
    public function videodel($id)
    {
        $res = Video::where('vid',$id)->update(['vstatus'=>2]);
        if($res){
            echo "<script>alert('删除成功');location.href='/admin/videolist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/admin/videolist'</script>";
        }
    }

}
