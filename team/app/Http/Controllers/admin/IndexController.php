<?php

namespace App\Http\Controllers\admin;

use App\Model\Material;
use App\Model\Subscribe;
use App\Wxshop\wxchat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * @content 后台首页
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @content 后台退出登录
     */
    public function editlogin()
    {
        return view('admin.login');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 后台首次关注回复视图
     */
    public function subscribe()
    {
        return view('admin/subscribe');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 后台首次关注回复添加
     */
    public function addsubscribe()
    {
       $type = \request()->type;
        $content = \request()->input('content',null);
        $title = \request()->input('title',null);
        $desc = \request()->input('desc',null);
        $returnurl = \request()->input('url',null);
        $create_time = time();
       if (\request()->hasFile('material')){
        //获取MediaId
           $data = $this->GetMediaId();
           $media_id = $data['media_id'];
           $url = $data['url'] ?? '';
           $all=['type'=>$type,'content'=>$content,'media_id'=>$media_id,'create_time'=>$create_time,'title'=>$title,'desc'=>$desc,'url'=>$url,'returnurl'=>$returnurl];
       }else{
           $all=['type'=>$type,'content'=>$content,'create_time'=>$create_time];
       }
        self::addMeateial($type);//添加素材
        $data = Subscribe::insert($all);
        if($data){
            echo "<script>alert('添加成功');location.href='/admin/subscribe'</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/admin/subscribe'</script>";
        }
    }

    /**
     * @return bool|mixed|string 返回 media_id
     */
    public function GetMediaId()
    {
        $file = \request()->material;
//dd($file);
        $data = wxchat::UploadsFile($file);
        $ext = $data['ext'];//上传的类型
        $path = storage_path().$data['path'];//图片路径
//                dd($path);
        //获取access_token  type
//        dd(wxchat::GetAccessToken());
        $token = json_decode(wxchat::GetAccessToken(),true)['access_token'];
        //获取类型
        $type = wxchat::GetMaterialType($ext);
        //上传链接
//        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
        //  CURLFile 专门为文件提交封装的类
        $data =['media'=>new \CURLFile(realpath($path))];
//                dd($data);
        $re = wxchat::HttpPost($url,$data); //"media_id"=>"w8Ao_cMidz6xrB0ERSHM3WfnHP5DwksErmespAeINR4G41AHo0W82lUnDkEobLGm"
        return $re;
    }

    /**
     * @param $type 素材的添加
     * @return bool 成功 true 失败 false
     */
    public function addMeateial($type)
    {
//        $type='image';
        $num = Material::where('type',$type)->count();
        $token = json_decode(Wxchat::GetAccessToken(),true)['access_token'];
        $url= "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token";
        $postdata = [
            'type'=>$type,
            'offest'=>$num,
            'count'=>20
        ];
//        dd($postdata);
        $json =json_encode($postdata,JSON_UNESCAPED_UNICODE);
//        dd($json);
        $info = Wxchat::HttpPost($url,$json);
        $count = $info['item_count'];
        for ($i=0;$i<=$count-1;$i++){
            $info['item'][$i]['type']=$type;
        }
        foreach ($info['item'] as $k=>$v){
//            dump($v);
            $re = Material::where(['media_id'=>$v['media_id']])->first();
            if($re){
                $res = Material::where(['media_id'=>$v['media_id']])->update(['media_id'=>$v['media_id'],'url'=>$v['url'],'name'=>$v['name'],'type'=>$v['type'],'update_time'=>$v['update_time']]);
            }else{
                $res = Material::insert($v);
            }
        }
        die;

        if($res !==false){
            return true;
        }else{
            return false;
        }
    }


}
