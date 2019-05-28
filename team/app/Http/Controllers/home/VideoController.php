<?php

namespace App\Http\Controllers\home;

use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 前台电影首页
     */
    public function index($id='')
    {
        $where = [['vstatus','=',1]];
        if($id != ''){
            $where[] = ['vtype','like',"%$id%"];
        }
        $data = Video::where($where)->paginate(5);
        return view('home/video',compact('data'));
    }
	/**
	 *@content 搜索
	 */
	public function search(Request $request)
    {
        $value=$request->keyword;
        if(!empty($value)){
            
            $con1=DB::table('video')->where('vname','like',"%$value%")->get()->toArray();
        }
        return view('home/searchvideo',compact('con1'));
    }

}
