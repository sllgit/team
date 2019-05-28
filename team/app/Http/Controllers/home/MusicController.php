<?php

namespace App\Http\Controllers\home;

use App\Model\Music;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MusicController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 前台音乐首页
     */
    public function index($id= '')
    {
        $where = [['mstatus','=',1]];
        if($id != ''){
            $where[] = ['mtype','like',"%$id%"];
        }
        $data = Music::where($where)->paginate(5);
        return view('home/music',compact('data'));
   }
   /**
	*@content 搜索
	*/
	public function search(Request $request)
	{
       $value=$request->keyword;
       if(!empty($value)){
           $con=DB::table('music')->where('mname','like',"%$value%")->get()->toArray();
       }
       return view('home/searchmusic',compact('con'));
	}
}
