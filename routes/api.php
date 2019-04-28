<?php

use App\Model\ImageClassification;
use App\Sporter;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/sporters', function (Request $request) {
    return Sporter::get(['id', 'name as text']);
});

Route::get('/image_classifications', function (Request $request) {
    return ImageClassification::get(['id', 'name as text']);
});

Route::post('/python', 'SecondHouseController@update');
Route::get('/get_link', 'SecondHouseController@getLink');

// 图片列表处理路由组
Route::prefix('image_list')->group(function () {
    Route::post('/store', 'ImgListController@store'); // 保存图片


});
