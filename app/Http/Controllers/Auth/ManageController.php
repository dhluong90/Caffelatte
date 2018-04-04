<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\FoodQModel;

class ManageController extends PageController {

    /**
    * Process list store in page site
    * @param user_id
    * @return list store 
    */
   public static function list_store_by_user_id($user_id) {
        $list_store = StoreQModel::get_list_store_by_user_id($user_id);
        if( !$list_store || !is_numeric($user_id)) {
            return view('vendor.adminlte.errors.404');
        }
        $count_food = 0;
        $collection =  [];
        foreach ($list_store as $store) {
            $count_food = FoodQModel::count_food_by_store_id($value->id);
            $store['count_food'] = $count_food;
            $value = (array)$value;
            $value['count_food'] = $count_food;
            $collection[] = $value;
        }
        $data['store'] = $collection;
        return view('pages.store.list', $data);
    }
   
   /**
    * Process list store in page site
    * @param store id
    * @return list food 
    */
    public static function get_list_food_by_store_id($store_id) {
        $data['food'] = FoodQModel::get_foods_by_store_id($store_id);
        return view('pages.store.list_food', $data);
    }
}
