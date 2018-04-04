<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class FoodCategoryCModel extends Model
{
    /**
     * insert food category
     * @param array data
     * @return boolean
     */
    public static function insert_food_category($data) {
        return DB::table(Constants::FOODS_CATEGORIES)->insert($data);
    }

    /**
     * update food category
     * @param $food_id int
     * @param $data array
     * @return boolean
     */
    public static function update_food_category($food_id, $data) {
        return DB::table(Constants::FOODS_CATEGORIES)
                ->where('food_id', '=', $food_id)
                ->update($data);
    }
}
