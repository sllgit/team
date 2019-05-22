<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Music;
class MusicController extends Controller
{
    /**
     * @content 音乐添加 及添加执行
     */
    public function addmusic()
    {
        if(\request()->Post()){
//            dd(\request()->all());
            $data = \request()->all();
            if($data['mtype'] == '0'){
                echo "<script>alert('类型不能为空');location.href='/admin/addmusic'</script>";
            }
            $res = Music::insert($data);
            if($res){
                echo "<script>alert('添加成功');location.href='/admin/musiclist'</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/admin/addmusic'</script>";
            }
        }else{
            return view('admin.addmusic');
        }

    }

    /**
     * @content 音乐列表
     */
    public function musiclist()
    {
        $request = request()->all();
        $where = [];
        $mname = $_GET['mname']??'';
        if($mname){
            $where[] = ['mname','like',"%$mname%"];
        }
        $mtype = $_GET['mtype']??'';
        if($mtype){
            $where[] = ['mtype','=',"$mtype"];
        }
        $data = Music::where('mstatus',1)->where($where)->paginate(3);
        return view('admin.musiclist',compact('data','request','mname','mtype'));
    }

    /**
     * @content 音乐列表修改
     */
    public function musicupd($id)
    {
        $data = Music::where('mid',$id)->first()->toArray();
        return view('admin/updmusic',compact('data'));
    }

    /**
     * @content 音乐列表修执行
     */
    public function musicupddo()
    {
        $data = \request()->all();
        if($data['mtype'] == '0'){
            echo "<script>alert('类型不能为空');location.href='/admin/musiclist'</script>";
        }
        $res = Music::where('mid',$data['mid'])->update($data);
        if($res){
            echo "<script>alert('修改成功');location.href='/admin/musiclist'</script>";
        }else{
            echo "<script>alert('修改失败');location.href='/admin/musiclist'</script>";
        }
    }

    /**
     * @content 音乐列表删除
     */
    public function musicdel($id)
    {
        $res = Music::where('mid',$id)->update(['mstatus'=>2]);
        if($res){
            echo "<script>alert('删除成功');location.href='/admin/musiclist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/admin/musiclist'</script>";
        }
    }

}
