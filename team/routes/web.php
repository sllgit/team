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
    return view('home/index');
});
Route::prefix('/admin')->middleware('admin/login')->group(function(){
    route::any('index','admin\IndexController@index');//后台首页

    route::any('addvideo','admin\VideoController@addvideo');//电影添加
    route::any('videolist','admin\VideoController@videolist');//电影列表
    route::any('videoupd/{id}','admin\VideoController@videoupd');//电影列表修改
    route::any('videoupddo','admin\VideoController@videoupddo');//电影列表修改执行
    route::any('videodel/{ids}','admin\VideoController@videodel');//电影列表删除

    route::any('addmusic','admin\MusicController@addmusic');//音乐添加
    route::any('musiclist','admin\MusicController@musiclist');//音乐列表
    route::any('musicupd/{id}','admin\MusicController@musicupd');//音乐列表修改
    route::any('musicupddo','admin\MusicController@musicupddo');//音乐列表修改执行
    route::any('musicdel/{id}','admin\MusicController@musicdel');//音乐列表删除

    route::any('subscribe','admin\IndexController@subscribe');//首次关注回复视图
    route::any('subscribe/add','admin\IndexController@addsubscribe');//首次关注回复添加

    route::any('materiallist','admin\MaterialController@materiallist');//素材列表
    route::any('materialupd/{id}','admin\MaterialController@materialupd');//素材列表修改
    route::any('materialdel/{id}','admin\MaterialController@materialdel');//素材列表删除
});

Route::prefix('/home')->group(function(){
    route::any('music/index','home\MusicController@index');//前台音乐首页
    route::any('video/index','home\VideoController@index');//前台电影首页

});

//防非法登录
Route::get('admin/login', function () {
    return view('admin/login');
});
Route::post('admin/logindo','admin\LoginController@logindo');
route::get('admin/login/quit','admin\LoginController@quit');