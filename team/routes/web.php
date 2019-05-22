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
});
