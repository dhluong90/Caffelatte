<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;
use App\Http\Models\Dal\FoodTagQModel;

class TagQModel extends Model
{
    /**
     * get tag by id
     * @param id
     * @return object|boolean : all properties from `tags` table, returns false if no tags is founded
     */
    public static function get_tag_by_id($id) {
        $result = DB::table(Constants::TAGS)
                ->where('id', '=', $id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * get list tags by store id
     * @param $store_id int
     * @return colection array
     */
    public static function get_tags_by_store_id($store_id) {
        return DB::table(Constants::TAGS. ' as t')
                ->select('t.id', 't.slug', 't.name')
                ->join(Constants::FOODS_TAGS. ' as ft', 'ft.tag_id', '=', 't.id')
                ->join(Constants::FOODS. ' as f', 'f.id', '=', 'ft.food_id')
                ->join(Constants::STORES. ' as s', 's.id', '=', 'f.store_id')
                ->where('s.id', '=', $store_id)
                ->distinct()
                ->get();
    }

    /**
     * get all tags
     * @return colection array
     */
    public static function get_all_tags() {
        return DB::table(Constants::TAGS. ' as t')
                ->select('t.id', 't.slug', 't.name')
                ->distinct()
                ->orderBy('name', 'asc')
                ->get();
    }

    /**
     * get all tags except array tag
     * @return colection array
     */
    public static function get_all_tags_except_array_tag($arr_slug_tag) {
        return DB::table(Constants::TAGS. ' as t')
                ->select('t.id', 't.slug', 't.name')
                ->distinct()
                ->whereNotIn('t.slug', $arr_slug_tag)
                ->get();
    }

    /**
     * get list tags except existed tags by food id
     * @param $food_id int
     * @return colection array
     */
    public static function get_all_tags_except_existed_tags_by_food_id($food_id) {
        // Get existed tags
        $existed_tags_id = DB::table(Constants::FOODS_TAGS . ' as ft')
                            ->select('ft.tag_id')
                            ->where('food_id', '=', $food_id)
                            ->pluck('ft.tag_id')
                            ->all();

        // Get all tags except existed tags
        return DB::table(Constants::TAGS . ' as t')
                ->select('t.id', 't.name' )
                ->whereNotIn('id', $existed_tags_id)
                ->get();
    }

    /**
     * get list tags except existed tags by slug tag
     * @param array slug tag
     * @return colection array
     */
    public static function get_tag_by_slug($arr_tag_slug) {
        return DB::table(Constants::TAGS)
            ->select('*')
            ->whereIn('slug', $arr_tag_slug)
            ->get();
    }

    /**
     * get list tags by food id
     * @author Khoa
     * @param array slug tag
     * @return colection array
     */
    public static function get_tags_by_food_id($food_id) {
        return DB::table(Constants::TAGS. ' as t')
            ->join(Constants::FOODS_TAGS. ' as ft', 'ft.tag_id', '=', 't.id')
            ->join(Constants::FOODS. ' as f', 'f.id', '=', 'ft.food_id')
            ->where('f.id', '=', $food_id)
            ->select('t.*')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }
}
