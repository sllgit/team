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


Route::prefix('/admin')->middleware('admin/login')->group(function(){
    route::any('index','admin\IndexController@index');//后台首页
    route::any('welcome','admin\IndexController@welcome');//后台首页欢迎

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
    route::any('settype','admin\IndexController@settype');//首次关注回复类型

    route::any('openidlist','admin\IndexController@openidlist');//关注者列表
    route::any('openidsend/{id}','admin\IndexController@openidsend');//关注者群发

    route::any('materiallist','admin\MaterialController@materiallist');//素材列表
    route::any('materialupd/{id}','admin\MaterialController@materialupd');//素材列表修改
    route::any('materialdel/{id}','admin\MaterialController@materialdel');//素材列表删除
});

//菜单添加
Route::prefix('/menu')->group(function (){
    route::any('menuadd','admin\MenuController@menuadd');//添加菜单
    route::any('menuadddo','admin\MenuController@menuadddo');//执行添加菜单
    route::any('menulist','admin\MenuController@menulist');//菜单列表
    route::any('getmenu/{id}','admin\MenuController@getmenu');//获取二级菜单
    route::any('menuedit/{id}','admin\MenuController@menuedit');//修改菜单
    route::any('menueditdo','admin\MenuController@menueditdo');//修改执行菜单
    route::any('menudel/{id}','admin\MenuController@menudel');//删除菜单
    route::any('cteatemenujog','admin\MenuController@cteatemenujog');//启用菜单
    route::any('delmenujog','admin\MenuController@delmenujog');//取消启用菜单
});

route::any('/','home\IndexController@index');//前台首页

Route::prefix('/home')->group(function(){
    route::any('music/index/{id?}','home\MusicController@index');//前台音乐首页
    route::any('video/index/{id?}','home\VideoController@index');//前台电影首页

	route::any('index/search/{id?}','home\IndexController@search');//首页搜索
    route::any('music/search/{id?}','home\MusicController@search');//音乐搜索
    route::any('video/search/{id?}','home\VideoController@search');//电影搜索

});
route::any('wxshop','WxController@wxshop');

route::any('/admin/getcode','home\IndexController@getcode');//获取微信授权登录code
route::any('/admin/wxlogin','home\IndexController@wxlogin');//微信授权登录
route::any('/admin/bindingdo','home\IndexController@bindingdo');//微信授权绑定用户登录

//防非法登录
Route::get('admin/login', function () {
    return view('admin/login');
});
Route::post('admin/logindo','admin\LoginController@logindo');
route::get('admin/login/quit','admin\LoginController@quit');