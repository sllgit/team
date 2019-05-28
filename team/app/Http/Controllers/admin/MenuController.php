<?php

namespace App\Http\Controllers\admin;

use App\Model\Menu;
use App\Wxshop\wxchat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Mul;

class MenuController extends Controller
{
    //菜单添加页面
    public function menuadd()
    {
        $data = Menu::where('pid',0)->get()->toArray();
        return view('admin.menuadd',['data'=>$data]);
    }

    public function menuadddo(Request $request)
    {
        $data = $request ->all();
        unset($data['menu']);
        $count = Menu::where(['pid'=>0,'status'=>1])->count();
        if($data['pid']==0){
            if($count >= 3){
                echo "<script>alert('一级菜单添加数目已达上限'),location.href='/menu/menuadd'</script>";
            }else{
                unset($data['_token']);
                $res = Menu::insert($data);
            }
        }else{
            $c = Menu::where(['pid'=>$data['pid'],'status'=>1])->count();
            if($c >= 5){
                echo "<script>alert('该一级菜单下子菜单已超过五条，请重新选择一级菜单'),location.href='/home/menuadd'</script>";
            }else{
                unset($data['_token']);
                $res = Menu::insert($data);
            }
        }
        if($res){
            echo "<script>alert('添加成功'),location.href='/menu/menulist'</script>";
        }else{
            echo "<script>alert('添加失败'),location.href='/menu/menuadd'</script>";
        }

    }
    /*
     * 菜单列表
     */
        public function menulist()
    {
        $arr = Menu::where(['status'=>1,'pid'=>0])->get();
        return view('admin.menulist',['data'=>$arr]);
    }

        /*
         *根据父类id获取子类
         */
        public function getmenu($id)
    {
        $data = Menu::where(['pid'=>$id,'status'=>1])->get();
//        echo $id;
        return $data;
    }
    /*
     * 删除
     */
    public function menudel(Request $request,$id)
    {
        //判断该菜单下是否有子菜单
        $data = Menu::where(['pid'=>$id,'status'=>1])->first();
        if(empty($data)){
            $res = Menu::where('id',$id)->update(['status'=>2]);
            if($res){
                echo "<script>alert('删除成功');location.href='/menu/menulist'</script>";
            }else{
                echo "<script>alert('删除失败');location.href='/menu/menulist'</script>";
            }
        }else{
            echo "<script>alert('此菜单下还有子菜单，不能删除');location.href='/menu/menulist'</script>";
        }
    }

    /*
     * 修改
     */
    public function menuedit(Request $request,$id)
    {
        $data1 = Menu::where(['pid'=>0,'status'=>1])->get();
        $data2 = Menu::where('id',$id)->first();
        return view('admin.menuedit',['data1'=>$data1,'data2'=>$data2]);
    }
    /*
     * 修改执行
     */
    public function menueditdo(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        if(count($data)==2){
            //修改的为一级菜单
            $res = Menu::where(['id'=>$data['id']])->update($data['name']);
        }else{
            $count = Menu::where(['pid'=>$data['pid']])->count();
            if($count >= 5){
                echo "<script>alert('该一级菜单下子菜单已超过五条，请重新选择一级菜单')</script>";
            }else{
                $res = Menu::where(['id'=>$data['id']])->update($data);
            }
        }
        if($res){
            echo "<script>alert('修改成功'),location.href='menulist'</script>";
        }else{
            echo "<script>alert('修改失败'),location.href='menuedit'</script>";
        }
    }
    /**
     * @content 创建菜单接口
     * */
    public function cteatemenujog()
    {
        //一级菜单
        $data = Menu::where('status',1)->get()->toArray();
        $menuinfo = [];
        foreach ($data as $k=>$v){//查询全部菜单
            if($v['pid'] == 0){//判断是否是一级菜单
                $res = Menu::where(['pid'=>$v['id'],'status'=>1])->get()->toArray();//查询一级菜单下是否有二级菜单
                if(empty($res)){//空
                    if($v['type'] == 'click'){
                        $menuinfo[] =[
                            'type'=>'click',
                            'name'=>$v['name'],
                            'key'=>$v['key']
                        ];
                    }else if ($v['type'] == 'view'){
                        $menuinfo[] =[
                            'type'=>'view',
                            'name'=>$v['name'],
                            'url'=>'http://'.$v['url']
                        ];
                    }
                }else{//有
                    $menuarr = [];
                    foreach ($res as $key => $val){//循环二级菜单存入数组中
                        if($val['type'] == 'click'){
                            $menuarr[] =[
                                'type'=>'click',
                                'name'=>$val['name'],
                                'key'=>$val['key']
                            ];
                        }else if ($val['type'] == 'view'){
                            $menuarr[] =[
                                'type'=>'view',
                                'name'=>$val['name'],
                                'url'=>'http://'.$val['url']
                            ];
                        }
                    }
                    //把一级和二级菜单拼接起来
                    $menuinfo[] = [
                        'name'=>$v['name'],
                        'sub_button'=>$menuarr
                    ];
                }

            }
        }
        //拼接成完整数组
        $postjson = [
            'button'=>$menuinfo
        ];
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".json_decode(wxchat::GetAccessToken(),true)['access_token'];
        $postjson = json_encode($postjson,JSON_UNESCAPED_UNICODE);
        $res = wxchat::HttpPost($url,$postjson);
        if($res['errcode'] == 0){
            echo "<script>alert('启用成功');location.href='/menu/menulist'</script>";
        }else{
            echo "<script>alert('启用失败');location.href='/menu/menulist'</script>";
        }
    }

    /**
     * @content 删除菜单接口
     * */
    public function delmenujog()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".json_decode(wxchat::GetAccessToken(),true)['access_token'];
        $res = file_get_contents($url);
        $res = json_decode($res,true);
        if($res['errcode'] == 0){
            echo "<script>alert('删除成功');location.href='/menu/menulist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/menu/menulist'</script>";
        }
    }
}
