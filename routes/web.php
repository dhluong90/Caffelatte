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

        Route::get('/', 'Admin\HomeController@index');

        // Users
        Route::group(['prefix' => 'user'], function () {
            Route::get('/member', 'Admin\UserController@list_member');

            // super admin
            Route::group(['middleware' => ['super_admin']], function () {
                Route::get('/admin', 'Admin\UserController@list_admin');
                Route::get('/set_admin/{user_id}','Admin\UserController@set_admin');
                Route::get('/unset_admin/{user_id}','Admin\UserController@unset_admin');
            });
        });

        // Categories
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'Admin\CategoryController@index');
            Route::get('/create', 'Admin\CategoryController@create');
            Route::post('/store', 'Admin\CategoryController@store');
            Route::get('/edit/{id}', 'Admin\CategoryController@edit');
            Route::post('/update/{id}', 'Admin\CategoryController@update');
            Route::get('/delete/{id}', 'Admin\CategoryController@delete');
        });

        // Products
        // Route::group(['prefix' => 'product'], function () {
        //     Route::get('/', 'Admin\ProductController@index');
        //     Route::post('/', 'Admin\ProductController@index');
        //     Route::get('/create', 'Admin\ProductController@create');
        //     Route::post('/store', 'Admin\ProductController@store');
        //     Route::get('/edit/{id}', 'Admin\ProductController@edit');
        //     Route::post('/update/{id}', 'Admin\ProductController@update');
        //     Route::get('/delete/{id}', 'Admin\ProductController@delete');
        // });

        // Tags
        Route::group(['prefix' => 'tag'], function () {
            Route::get('/', 'Admin\TagController@index');
            Route::get('/create', 'Admin\TagController@create');
            Route::post('/store', 'Admin\TagController@store');
            Route::get('/edit/{id}', 'Admin\TagController@edit');
            Route::post('/update/{id}', 'Admin\TagController@update');
            Route::get('/delete/{id}', 'Admin\TagController@delete');
        });

        // Stores
        Route::group(['prefix' => 'store'], function () {
            Route::get('/', 'Admin\StoreController@index');
            Route::any('/search_approve', 'Admin\StoreController@search_list_approved_stores');
            Route::any('/search_pending', 'Admin\StoreController@search_list_pending_stores');

            Route::get('/pending', 'Admin\StoreController@list_pending_stores');
            Route::post('/pending', 'Admin\StoreController@list_pending_stores');
            Route::get('/approve/{id}', 'Admin\StoreController@approve_store');

            //Route::get('/create', 'Admin\StoreController@create');
            //Route::post('/store', 'Admin\StoreController@store');

            //Route::get('/edit/{id}', 'Admin\StoreController@edit');
            //Route::post('/update/{id}', 'Admin\StoreController@update');
            Route::get('/delete/{id}', 'Admin\StoreController@delete');
            //Route::get('/view/{slug}/{id}', 'Admin\StoreController@detail_store');

        });

        // Foods
        Route::group(['prefix' => 'food'], function () {
            Route::get('/', 'Admin\FoodController@index');
            Route::any('/search_approved', 'Admin\FoodController@search_list_approved_foods');

            Route::get('/pending', 'Admin\FoodController@list_pending_foods');
            Route::any('/search_pending', 'Admin\FoodController@search_list_pending_foods');

            Route::get('/delete/{id}', 'Admin\FoodController@delete');

            Route::get('/view/{slug}/{id}', 'Admin\FoodController@detail_food');

            Route::get('/approve/{id}', 'Admin\FoodController@approve_food');
        });
    });
});

// Error
Route::get('/error', function(){
    return view('vendor.adminlte.errors.notyet');
});
