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
    // Home
    Route::get('/', 'HomeController@index');

    // Store
    Route::get('/store/view/{store_slug}/{store_id}', 'StoreController@detail');

    // Food
    Route::get('/food', 'FoodController@list_food')->name('website_food_list');
    Route::get('/food/view/{food_slug}/{food_id}', 'FoodController@detail')->name('website_food_detail');

    // Search
    Route::get('/search', 'SearchController@index')->name('website_food_search');

    // Category
    Route::get('/category/view/{category_slug}', 'CategoryController@detail')->name('website_category_view');

    // Pages need check login
    Route::group(['middleware' => ['auth']], function () {

        // Manage Store
        Route::group(['middleware' => ['store_manager']], function () {
            Route::get('/manage/store/{store_id}/create_food', 'ManageStoreController@create_food');
            Route::post('/manage/store/{store_id}/post_create_food', 'ManageStoreController@post_create_food');
            Route::get('/manage/store/{store_id}/edit_food/{food_id}', 'ManageStoreController@edit_food');
            Route::post('/manage/store/{store_id}/post_edit_food/{food_id}', 'ManageStoreController@post_edit_food');
            Route::get('/manage/store/{store_id}/food', 'ManageStoreController@list_food')->name('website_manage_store_food_list');
            Route::get('/manage/store/{store_id}/edit_store', 'ManageStoreController@edit_store');
            Route::post('/manage/store/{store_id}/post_edit_store', 'ManageStoreController@post_edit_store');
            Route::get('/manage/store/{store_id}/delete', 'ManageStoreController@delete_store');
            Route::get('/manage/store/{store_id}/delete_food/{food_id}', 'ManageStoreController@delete_food');
        });

        // View profile
        Route::get('/profile/{user_id}', 'ProfileController@detail_user')->name('website_profile_detail');
        Route::get('/profile/{user_id}/store', 'ProfileController@list_store')->name('website_profile_store_list');

        // Manage Profile
        Route::group(['middleware' => ['profile_manager']], function () {
            Route::get('/profile/{user_id}/create_store', 'ProfileController@create_store');
            Route::post('profile/{user_id}/post_create_store', 'ProfileController@post_create_store');
            Route::get('/profile/{user_id}/edit', 'ProfileController@edit_user');
            Route::post('/profile/{user_id}/update', 'ProfileController@update_user');
        });
    });

// Ajax
    Route::group(['prefix' => 'ajax'], function () {

        Route::group(['middleware' => 'auth'], function () {

            //ajax food
            Route::group(['prefix' => 'food'], function () {
                //like feature
                Route::get('/like/{food_id}', 'Ajax\FoodController@like_food');
                Route::get('/dislike/{food_id}', 'Ajax\FoodController@dislike_food');
                //comment feature
                Route::post('/comment', 'Ajax\FoodController@comment_food');
            });
            
            //ajax store
            Route::group(['prefix' => 'store'], function () {
                //like feature
                Route::get('/like/{store_id}', 'Ajax\StoreController@like_store');
                Route::get('/dislike/{store_id}', 'Ajax\StoreController@dislike_store');
                //follow feature
                Route::get('/follow/{store_id}', 'Ajax\StoreController@follow_store');
                Route::get('/unfollow/{store_id}', 'Ajax\StoreController@unfollow_store');
                //comment feature
                Route::post('/comment', 'Ajax\StoreController@comment_store');
            });

            //ajax user
            Route::group(['prefix' => 'user'], function () {
                Route::get('/follow/{user_id}', 'Ajax\UserController@follow_user');
                Route::get('/unfollow/{user_id}', 'Ajax\UserController@unfollow_user');
            });
        });
        
    });

// Partial
    Route::group(['prefix' => 'partial'], function () {
        Route::get('/food/get_video', 'Partial\FoodController@get_video');
        Route::get('/home/load_more', 'Partial\HomeController@load_more');
        Route::get('/search/load_more_search', 'Partial\SearchController@load_more_search');
        Route::get('/store/{store_id}/list_food', 'Partial\StoreController@list_food');
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

            // Blogs
            // Route::group(['prefix' => 'blog'], function () {
            //     Route::get('/', 'Admin\BlogController@index');
            //     Route::get('/create', 'Admin\BlogController@create');
            //     Route::post('/store', 'Admin\BlogController@store');
            //     Route::get('/edit/{id}', 'Admin\BlogController@edit');
            //     Route::post('/update/{id}', 'Admin\BlogController@update');
            //     Route::get('/delete/{id}', 'Admin\BlogController@delete');
            // });

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
// Tools
    // Route::get('/tool/demo', 'ToolController@index');
    // Route::get('/tool/demo_paging', 'ToolController@demo_paging');
    // Route::get('/tool/demo_hash_password', 'ToolController@demo_hash_password');
    // Route::get('/tool/demo_upload_image', 'ToolController@demo_upload_image');
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['super_admin']], function(){
            Route::group(['prefix' => 'tool'], function(){
                Route::get('/update_user_store', 'ToolController@update_user_store');
                Route::get('/set_created_at', 'ToolController@set_time_created_at');
            });
        });
    });

    