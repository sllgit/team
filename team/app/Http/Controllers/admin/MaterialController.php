<?php

namespace App\Http\Controllers\admin;

use App\Model\Material;
use App\Wxshop\wxchat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * @content 素材列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 素材列表
     */
    public function materiallist()
    {
        $request = $_GET;
        $type = \request()->type ?? '';
        $where = [];
        if($type){
            $where[] =['type','=',$type];
        }
        $data =Material::where($where)->paginate(3);
        return view('admin/materiallist',compact('data','request','type'));
    }

    /**
     * @content 首次回复的修改
     * @param $id 要修改的id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 修改的页面
     */
    public function materialupd($id)
    {
        $data = Material::where('id',$id)->first();
//        dd($data);
        return view('admin/material/mediaupd',['data'=>$data]);
    }

    /**
     * @content 素材列表删除
     * @param $id 要删除的id
     */
    public function materialdel($id)
    {
        $media_id = Material::where('id',$id)->value('media_id');
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=".json_decode(wxchat::GetAccessToken(),true)['access_token'];
        $info =[
            'media_id'=>$media_id
        ];
        $info = json_encode($info);
        $res = wxchat::HttpPost($url,$info);
        if($res['errcode'] == 0){
            $data =Material::where('id',$id)->delete();
            if($data){
                echo "<script>alert('删除成功');location.href='/admin/medialist'</script>";
            }else{
                echo "<script>alert('删除失败');location.href='/admin/medialist'</script>";
            }
        }else{
            echo "<script>alert('".$res."');location.href='/admin/medialist'</script>";
        }
    }

}
