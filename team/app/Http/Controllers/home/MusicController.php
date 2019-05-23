<?php

namespace App\Http\Controllers\home;

use App\Model\Music;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MusicController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 前台音乐首页
     */
    public function index()
    {
        $data = Music::get()->toArray();
        return view('home/music',compact('data'));
   }
}
