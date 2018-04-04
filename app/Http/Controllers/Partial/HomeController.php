<?php

namespace App\Http\Controllers\Partial;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Models\Business\StoreModel;
use App\Http\Models\Business\UserModel;
use App\Http\Helpers\Constants;

class HomeController extends Controller
{
    /**
     * Get foods, stores, users to display on load more.
     *
     * @return \Illuminate\Http\Response
     */
    public function load_more() {
        if(isset($_GET['food_start_id']) && isset($_GET['page'])) {
            $limit = Constants::HOME_MAIN_FOOD_ITEMS;
            $offset = ($_GET['page'] - 1) * $limit;
            $foods_temp = FoodQModel::get_foods_load_more($_GET['food_start_id'], $offset, $limit);
            if (count($foods_temp) > 0) {
                foreach ($foods_temp as $food) {
                    $food->type = 'food';
                    $foods[] = $food;
                }

                $stores = [];
                if(isset($_GET['store_start_id'])) {
                    $limit = Constants::HOME_MAIN_STORE_ITEMS;
                    $offset = ($_GET['page'] - 1) * $limit;
                    $stores_temp = StoreQModel::get_stores_load_more($_GET['store_start_id'], $offset, $limit);
                    foreach ($stores_temp as $store) {
                        $store->type = 'store';
                        $stores[] = $store;
                    }
                }

                $users = [];
                if(isset($_GET['user_start_id'])) {
                    $limit = Constants::HOME_MAIN_USER_ITEMS;
                    $offset = ($_GET['page'] - 1) * $limit;
                    $users_temp = UserQModel::get_users_load_more($_GET['user_start_id'], $offset, $limit);
                    foreach ($users_temp as $user) {
                        $user->type = 'user';
                        $users[] = $user;
                    }
                }

                //Create variable to store foods, users and stores
                $data['items_main_content'] = array_merge($foods, $stores, $users);
                //Random items main content
                shuffle($data['items_main_content']);

                if (Auth::id()) {
                    $data['foods_like_id'] = FoodModel::get_foods_like_id_by_user_id(Auth::id());

                    $data['stores_like_id'] = StoreModel::get_stores_like_id_by_user_id(Auth::id());

                    $data['stores_follow_id'] = StoreModel::get_stores_follow_id_by_user_id(Auth::id());

                    $data['users_follow_id'] = UserModel::get_user_follow_id_by_follower_id(Auth::id());
                }

                return view('pages.partials.shared.main_list', $data);
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

}
