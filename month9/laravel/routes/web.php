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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//注册
Route::get('/res','RegisterController@res');
Route::post('/reg','RegisterController@reg');
//登录
Route::get('/logins','RegisterController@logins');
Route::get('/logins2','RegisterController@logins2');
Route::post('/logined','RegisterController@logined');
Route::post('/logined2','RegisterController@logined2');



Route::get('/sendcode','RegisterController@sendcode');

Route::get('/sign','RegisterController@sign');