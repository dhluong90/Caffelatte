<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Models\Business\StoreModel;
use App\Http\Models\Business\UserModel;
use App\Http\Helpers\Constants;

class HomeController extends PageController 
{
    /**
     * Show layout home page
     */
    public function index() {
        // Get foods to display at slider
        $data['foods_slider'] = FoodQModel::get_foods(0, Constants::HOME_MAIN_SLIDER_FOOD_ITEMS);
        foreach ($data['foods_slider'] as $food) {
            $food->tags = TagQModel::get_tags_by_food_id($food->id);
        }

        $data['foods_tag'] = TagQModel::get_all_tags();

        //Declare variable limit items
        $food_items_limit = Constants::HOME_MAIN_FOOD_ITEMS;
        $store_items_limit = Constants::HOME_MAIN_STORE_ITEMS;
        $user_items_limit = Constants::HOME_MAIN_USER_ITEMS;

        // Check isset tag_slug
        if (isset($_GET['foods_tag'])) {
            // Get foods of store by tag_slug
            $foods_temp = FoodQModel::get_foods_by_tag_slug($_GET['foods_tag']);
            if(FoodQModel::count_rows_by_tag_slug($_GET['foods_tag']) >= $food_items_limit) {
                $data['total_nums_food'] = FoodQModel::count_rows_by_tag_slug($_GET['foods_tag']) - $food_items_limit;
            } else {
                $data['total_nums_food'] = 0;
            }
        } else {
            //Get foods to display at main content
            $foods_temp = FoodQModel::get_foods_for_main_content($food_items_limit);
        }

        $foods = [];
        foreach ($foods_temp as $food) {
            $food->type = 'food';
            $foods[] = $food;
        }

        //Get stores to display at main content
        $stores_temp = StoreQModel::get_stores_for_main_content($store_items_limit);
        $stores = [];
        foreach ($stores_temp as $store) {
            $store->type = 'store';
            $stores[] = $store;
        }

        //Get users to display at main content
        $users = [];
        $users_temp = UserQModel::get_users_for_main_content($user_items_limit);
        foreach ($users_temp as $user) {
            $user->type = 'user';
            $users[] = $user;
        }

        //Create variable to store start ids for load more
        $data['load_more'] = [
            'food_start_id' => (!empty($food->id)) ? $food->id : 0,
            'store_start_id' => (!empty($store->id)) ? $store->id : 0,
            'user_start_id' => (!empty($user->id)) ? $user->id : 0,
        ];

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
        return view('pages.home.home', $data);
    }
}