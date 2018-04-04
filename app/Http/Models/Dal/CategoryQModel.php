<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class CategoryQModel extends Model
{
    /**
     * get category by id
     * @param id
     * @return object|boolean : all properties from `categories` table,
     * returns false if no categories is founded
     */
    public static function get_category_by_id($id) {
        $result = DB::table(Constants::CATEGORIES)
                ->where('id', '=', $id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * get category by slug
     * @param $category_slug string
     * @return object|boolean : all properties from `categories` table,
     * returns false if no categories is founded
     */
    public static function get_category_by_slug($category_slug) {
        $result = DB::table(Constants::CATEGORIES)
                ->where('slug', '=', $category_slug)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * get all categories
     * @return array
     */
    public static function get_categories() {
        return DB::table(Constants::CATEGORIES)
                ->get();
    }

    /**
     * get all parent categories
     * 
     * @return array
     */
    public static function get_parent_categories() {
        return DB::table(Constants::CATEGORIES)
                ->where('parent_id', '=', 0)
                ->get();    
    }

    /**
     * get all child categories
     * @param $parent_id int
     * @return array
     */
    public static function get_child_categories_by_parent_id($parent_id) {
        return DB::table(Constants::CATEGORIES)
                ->where('parent_id', '=', $parent_id)
                ->get();    
    } 
    
    /**
     * get category by food_id 
     * @return object Collection
     */
    public static function get_categories_by_food_id($food_id){
        return DB::table(Constants::FOODS_CATEGORIES)
                ->select('id')
                ->where('food_id', '=', $food_id)
                ->get();
    } 
    /**
     * get category id by slug
     * @param category_slug
     * @return category_id
     */
    public static function get_category_id_by_category_slug($category_slug){
        $data = DB::table(Constants::CATEGORIES)
                ->select('id')
                ->where('slug','=',$category_slug)
                ->first();
        return $data->id;
    }
}
