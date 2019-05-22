<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('/admin')->group(function(){
    route::any('index','admin\IndexController@index');//后台首页
    route::any('editlogin','admin\IndexController@editlogin');//后台退出登录
    route::any('addvideo','admin\IndexController@addvideo');//电影添加
});
