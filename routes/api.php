<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'Api\AuthController@login');
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'api.token'], function () {
        Route::put('/update', 'Api\CustomerController@update');
        Route::get('/suggest', 'Api\CustomerController@suggest');
        Route::get('/profile/{id}', 'Api\CustomerController@profile');
        Route::post('/like', 'Api\CustomerController@like');
        Route::post('/pass', 'Api\CustomerController@pass');
        Route::post('/unmatch', 'Api\CustomerController@unmatch');
        Route::get('/list_unmatch', 'Api\CustomerController@list_unmatch');
        Route::get('/manual_friend/{id}', 'Api\CustomerController@manual_friend');
        Route::post('/push/{matching_id}', 'Api\CustomerController@push_user');
    });
});

Route::group(['prefix' => 'sticker'], function () {
    Route::get('/list', 'Api\StickerController@list_sticker');
});

// Route::group(['prefix' => 'tool'], function () {
//     Route::get('/update_friend', 'Api\ToolController@update_friend');
//     Route::get('/update_image', 'Api\ToolController@update_image');
// });
