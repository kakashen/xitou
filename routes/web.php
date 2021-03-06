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

Route::get('/wxmsg', 'WeChatController@checkSignature');

Route::any('/wechat', 'WeChatController@serve');

Route::any('/chat', 'ChatController@insert');

Route::any('/infos', 'SunnyController@infos');
