<?php

namespace App\Http\Controllers\admin;


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




}
