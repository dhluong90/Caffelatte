<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class FoodLikeCModel extends Model
{
	/**
     * insert food like record
     * @param array data
     * @return boolean
     */
    public static function insert_food_like($data) {
        return DB::table(Constants::FOODS_LIKES)->insertGetId($data);
    }

    /**
     * delete food like
     * @param id
     * @return boolean
     */
    public static function delete_food_like($id) {
        return DB::table(Constants::FOODS_LIKES)
                ->where('id', $id)
                ->delete();
    }
}
