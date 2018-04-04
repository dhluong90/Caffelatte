<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class FoodTagCModel extends Model
{
    /**
     * insert food tag
     * @param array data
     * @return boolean
     */
    public static function insert_food_tag($data) {
        return DB::table(Constants::FOODS_TAGS)->insert($data);
    }

    /**
     * delete food tag by food id
     * @param $food_id int
     * @return boolean
     */
    public static function delete_food_tag_by_food_id($food_id) {
        return DB::table(Constants::FOODS_TAGS)
            ->where('food_id', '=', $food_id)
            ->delete();
    }
}
