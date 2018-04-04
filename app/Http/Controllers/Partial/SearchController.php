<?php

namespace App\Http\Controllers\Partial;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Helpers\Constants;

class SearchController extends Controller
{
    /**
     * Get foods, stores, users to display on load more.
     *
     * @return \Illuminate\Http\Response
     */
    public function load_more_search() {
        if(isset($_GET['search_string']) && isset($_GET['food_start_id']) && isset($_GET['page'])) {
            $limit = Constants::SEARCH_MAIN_FOOD_ITEMS;
            $offset = ($_GET['page'] - 1) * $limit;
            $foods_temp = FoodQModel::search_foods_by_name_load_more($_GET['search_string'], $_GET['food_start_id'], $offset, $limit);
            $foods = [];
            foreach ($foods_temp as $food) {
                $food->type = 'food';
                $foods[] = $food;
            }

            $stores = [];
            if(isset($_GET['store_start_id'])) {
                $limit = Constants::SEARCH_MAIN_STORE_ITEMS;
                $offset = ($_GET['page'] - 1) * $limit;
                $stores_temp = StoreQModel::search_store_by_name_load_more($_GET['search_string'], $_GET['store_start_id'], $offset, $limit);
                foreach ($stores_temp as $store) {
                    $store->type = 'store';
                    $stores[] = $store;
                }
            }

            $users = [];
            if(isset($_GET['user_start_id'])) {
                $limit = Constants::SEARCH_MAIN_USER_ITEMS;
                $offset = ($_GET['page'] - 1) * $limit;
                $users_temp = UserQModel::search_user_by_name_or_phone_or_email_load_more($_GET['search_string'], $_GET['user_start_id'], $offset, $limit);
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
                $foods_like = FoodQModel::get_like_foods_by_user_id(Auth::id());
                $data['foods_like_id'] = [];
                foreach ($foods_like as $food) {
                    array_push($data['foods_like_id'], $food->id);
                }

                $stores_like = StoreQModel::get_like_stores_by_user_id(Auth::id());
                $data['stores_like_id'] = [];
                foreach ($stores_like as $store) {
                    array_push($data['stores_like_id'], $store->id);
                }
            }

            return view('pages.partials.shared.main_list', $data);
        } else {
            return '';
        }
    }

}
