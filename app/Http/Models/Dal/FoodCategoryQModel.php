<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class FoodCategoryQModel extends Model
{
    /**
     * get category by food_id
     * @param $food_id int
     * @return object|boolean : all properties from `foods_categories` table,
     * returns false if no tag is founded
     */
    public static function get_categories_by_food_id($food_id) {
        $result = DB::table(Constants::FOODS_CATEGORIES . ' as fc')
                ->select('fc.category_id', 'c.name')
                ->where('food_id', '=', $food_id)
                ->join(Constants::CATEGORIES . ' as c', 'c.id', '=', 'fc.category_id')
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }

        return $result[0];
    }

    /**
     * get category_id by food_id
     * @param $food_id int
     * @return object|boolean : category_id from `foods_categories` table,
     * returns false if no tag is founded
     */
    public static function get_category_id_by_food_id($food_id) {
        return DB::table(Constants::FOODS_CATEGORIES . ' as fc')
                ->select('fc.category_id')
                ->where('food_id', '=', $food_id)
                ->join(Constants::CATEGORIES . ' as c', 'c.id', '=', 'fc.category_id')
                ->pluck('fc.category_id')
                ->all();
    }
}
