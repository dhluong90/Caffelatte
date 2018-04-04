<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Models\Business\StoreModel;
use App\Http\Models\Business\UserModel;
use App\Http\Helpers\Constants;
use Auth;

class SearchController extends PageController 
{
	/**
     * search, filer food in page home.
     * @return \Illuminate\Http\Response
     */
	public function index() {
        if (isset($_GET['q'])) {
            //Declare variable limit items
            $food_items_limit = Constants::SEARCH_MAIN_FOOD_ITEMS;
            $store_items_limit = Constants::SEARCH_MAIN_STORE_ITEMS;
            $user_items_limit = Constants::SEARCH_MAIN_USER_ITEMS;

            //Get foods to display
            $foods_temp = FoodQModel::search_food_by_name($_GET['q'], $food_items_limit);
            $foods = [];
            foreach ($foods_temp as $food) {
                $food->type = 'food';
                $foods[] = $food;
            }

            //Get stores to display
            $stores_temp = StoreQModel::search_store_by_name($_GET['q'], $store_items_limit);
            $stores = [];
            foreach ($stores_temp as $store) {
                $store->type = 'store';
                $stores[] = $store;
            }

            //Get users to display
            $users_temp = UserQModel::search_user_by_name_or_phone_or_email($_GET['q'], $user_items_limit);
            $users = [];
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

            $data['tags_show'] = TagQModel::get_all_tags();
            $data['view_all_tag'] = TRUE;
            $arr_tag = [];
            $data['foods_tag'] = TagQModel::get_all_tags_except_array_tag($arr_tag);

            if (Auth::id() != null) {
                $data['foods_like_id'] = FoodModel::get_foods_like_id_by_user_id(Auth::id());

                $data['stores_like_id'] = StoreModel::get_stores_like_id_by_user_id(Auth::id());

                $data['stores_follow_id'] = StoreModel::get_stores_follow_id_by_user_id(Auth::id());
                
                $data['users_follow_id'] = UserModel::get_user_follow_id_by_follower_id(Auth::id());
            }
            return view('pages.search.search', $data);
        }
    }
}