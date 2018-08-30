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

// Web application
Route::get('/', function () {
    echo 'hello';
});

// Ajax
Route::group(['prefix' => 'ajax'], function () {
});

// Partial
Route::group(['prefix' => 'partial'], function () {
});

// Web admin
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admincp', 'middleware' => ['manager']], function () {

        Route::get('/', function () {
            return redirect('admincp/user/member');
        });

        // Users
        Route::group(['prefix' => 'user'], function () {
            Route::get('/member', 'Admin\UserController@list_member');
            Route::get('/profile/{user_id}','Admin\UserController@get_user_profile');
            Route::post('/profile/{user_id}/update', 'Admin\UserController@update_user_profile');
            // super admin
            Route::group(['middleware' => ['super_admin']], function () {
                Route::get('/admin', 'Admin\UserController@list_admin');
                Route::get('/set_admin/{user_id}','Admin\UserController@set_admin');
                Route::get('/unset_admin/{user_id}','Admin\UserController@unset_admin');
            });
        });
    });
});

// Error
Route::get('/error', function(){
    return view('vendor.adminlte.errors.notyet');
});

Route::group(['prefix' => 'webhook'], function () {
    Route::post('/branch_io', 'BranchIoController@webhook');
});