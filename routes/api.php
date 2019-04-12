<?php

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

Route::get('/image-classification', function (Request $request) {
    return Sporter::get(['id', 'name as text']);
});