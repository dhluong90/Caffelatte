<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class FoodCModel extends Model
{
	/**
     * delete a food
     * @param $id int
     * @return boolean
     */
    public static function delete_food($id) {
        return DB::table(Constants::FOODS)
            ->where('id', '=', $id)
            ->delete();
    }

    /**
     * update food
     * @param id
     * @param array data
     * @return boolean
     */
    public static function update_food($id, $data) {
        return DB::table(Constants::FOODS)
                ->where('id', '=', $id)
                ->update($data);
    }
    
    /**
     * delete foods of store by store_id
     * @param $store_id int
     * @return boolean
     */
    public static function delete_foods_by_store_id($store_id) {
        return DB::table(Constants::FOODS)
            ->where('store_id', '=', $store_id)
            ->delete();
    }

    /**
     * insert food
     * @param array $data
     * @return last inserted id
     */
    public static function insert_food($data) {
        return DB::table(Constants::FOODS)->insertGetId($data);
    }
}
