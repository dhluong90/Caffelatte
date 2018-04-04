<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class FoodTagQModel extends Model
{
    /**
     * get all tags by food_id
     * @param $food_id int
     * @return object|boolean : all properties from `foods_tags` table,
     * returns false if no tag is founded
     */
    public static function get_tags_by_food_id($food_id) {
        return DB::table(Constants::FOODS_TAGS . ' as ft')
                ->select('ft.tag_id', 't.name')
                ->where('food_id', '=', $food_id)
                ->join(Constants::TAGS . ' as t', 't.id', '=', 'ft.tag_id')
                ->get();
    }

    /**
     * get tag_ids by food_id
     * @param $food_id int
     * @return object|boolean : tag_id from `foods_tags` table,
     * returns false if no tag is founded
     */
    public static function get_tag_ids_by_food_id($food_id) {
        return DB::table(Constants::FOODS_TAGS . ' as ft')
                ->select('ft.tag_id')
                ->where('food_id', '=', $food_id)
                ->join(Constants::TAGS . ' as t', 't.id', '=', 'ft.tag_id')
                ->pluck('ft.tag_id')
                ->all();
    }
}
