<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Models\Business\PostModel;
use App\Http\Helpers\Constant;
use App\Http\Models\Dal\PostQModel;
use App\Http\Helpers\Constants;
use App\Http\Models\Dal\StoreUserQModel;
use App\Http\Models\Dal\StoreUserCModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\FoodCModel;

class ToolController extends PageController
{
    /**
     * Show demo
     *
     * @return Response
     */
    public function index()
    {
        // var_dump($data);
        echo Constant::ROLES_ADMIN;

        $posts = PostModel::all();
        echo '<pre>';
            var_dump($posts);
        echo '</pre>';

        // foreach ($posts as $post) {
        //     echo $post->name . ' - ' . $post->user_id;
        //     echo '</br>';
        // }


    }

    public function demo_paging() {
        // $posts = DB::table('posts')->paginate(2);
        // echo '<pre>';
        //     var_dump($posts);
        // echo '</pre>';
        $posts = PostQModel::get_posts_paging();
        echo '<pre>';
            var_dump($posts);
        echo '</pre>';
        // echo $posts->links();
        return view('pages.home.home');
    }

    public function demo_debug() {
        // document https://github.com/barryvdh/laravel-debugbar

        // Debugbar::info($object);
        // Debugbar::error('Error!');
        // Debugbar::warning('Watch out…');
        // Debugbar::addMessage('Another message', 'mylabel');

        // Debugbar::startMeasure('render','Time for rendering');
        // Debugbar::stopMeasure('render');
        // Debugbar::addMeasure('now', LARAVEL_START, microtime(true));
        // Debugbar::measure('My long operation', function() {
        //     // Do something…
        // });
    }

    public function demo_hash_password() {
        echo '<pre>';
            // var_dump(Hash::make('123124'));
            // var_dump(Hash::check('123123','$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO'));
            var_dump(Hash::check('123123','$2y$10$Ygza8kBIBfGuwj6ywzlFTeKus6Smvhc/qJAmT00ZM4Z2q9mfaSmXi'));
        echo '</pre>'; 
    }

    public function demo_upload_image() {
        return view('pages.tool.upload_image');
    }

    public function update_user_store() {
        $users_id = UserQModel::get_users_id();
        foreach ($users_id as $user_id) {
            $stores_id = StoreUserQModel::get_stores_id_by_user_id($user_id->id);
            foreach ($stores_id as $store_id) {
                if (!StoreQModel::get_store_by_id($store_id->store_id)) {
                    StoreUserCModel::delete_store_user_by_store_id($store_id->store_id);
                    echo '<p>Đã xóa store với id='.$store_id->store_id.' của user với id='.$user_id->id.'</p>';
                }
            }
        }

    }
    /**
     * set time created_at to food, store
     */ 
    public function set_time_created_at() {
        $foods = FoodQModel::get_foods_created_at_null();
        $stores = StoreQModel::get_stores_created_at_null();

        foreach ($foods as $food) {
            $data = ['created_at' => time()];
            FoodCModel::update_food($food->id, $data);
            echo '<p>Đã thêm created_at cho food có id='.$food->id.' name='.$food->name.'</p>';
        }

        foreach ($stores as $store) {
            $data = ['created_at' => time()];
            StoreCModel::update_store($store->id, $data);
            echo '<p>Đã thêm created_at cho store có id='.$store->id.' name='.$store->name.'</p>';
        }
    }
}
