<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class FoodQModel extends Model
{
    /**
     * get food by id
     * @param $id int
     * @return object|boolean : all properties from `foods` table,
     * returns false if no food is founded
     */
    public static function get_food_by_id($id) {
        $result = DB::table(Constants::FOODS)
                ->where('id', '=', $id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }
    
    /**
     * get foods paging
     *
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function get_approved_foods_paging() {
        return DB::table(Constants::FOODS)
                ->where('status', '=', Constants::FOOD_APPROVE)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    }

    /**
     * Search approve foods paging
     * @param $search string
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_approved_foods_paging($search) {
        return DB::table(Constants::FOODS)
                ->where('name', 'like', '%'.$search.'%') 
                ->where('status', '=', Constants::FOOD_APPROVE)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    }

    /**
     * Get pending foods paging
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function get_pending_foods_paging() {
        return DB::table(Constants::FOODS . ' as f')
                ->join(Constants::STORES . ' as s', 's.id', '=', 'f.store_id')
                ->select('f.*', 's.name as store_name')
                ->where('s.status', '=', Constants::STORE_APPROVE)
                ->where('f.status', '=', Constants::FOOD_PENDING)
                ->orderBy('f.id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    } 

    /**
     * Search pending foods paging
     * @param $search string
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_pending_foods_paging($search) {
        return DB::table(Constants::FOODS)
                ->where('name', 'like', '%'.$search.'%') 
                ->where('status', '=', Constants::FOOD_PENDING)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    }

    /**
     * get foods to display at main content
     * @return object Collection
     */
    public static function get_foods_for_main_content($limit) {
        return DB::table(Constants::FOODS . ' as f')
                ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
                ->select('f.*', 'u.name as user_name', 'u.image as user_image', 'u.id as user_id', 'u._follow as user_follow')
                ->where('f.status', '=', Constants::FOOD_APPROVE)
                ->orderBy('f.id', 'DESC')
                ->limit($limit)
                ->get();
    }

    /**
     * get foods of store by tag_slug, store_id
     * @param $store_id  int
     * @param $tag_slug  string
     * @return paging colection array
     */
    public static function get_foods_of_store_paging_by_tag_slug($tag_slug, $store_id) {
        return DB::table(Constants::FOODS . ' as f')
                ->select('f.id', 'f.images', 'f.name', 'f.detail', 'f.slug', 'f.price', 't.slug', 'f.store_id')
                ->join(Constants::FOODS_TAGS . ' as ft', 'ft.food_id', '=', 'f.id')
                ->join(Constants::TAGS . ' as t', 't.id', '=', 'ft.tag_id')
                ->join(Constants::STORES . ' as s', 's.id', '=', 'f.store_id')
                ->whereIn('t.slug', $tag_slug)
                ->where('f.store_id', '=', $store_id)
                ->where('f.status', '=', Constants::FOOD_APPROVE)
                ->orderBy('f.id', 'desc')
                ->paginate(Constants::DETAIL_STORE_FOODS_PAGING);
    }

    /**
     * get foods in page detail food. Slider
     * @return object Collection
     */
    public static function get_foods_by_store($food_id, $store_id) {
        return DB::table(Constants::FOODS)
            ->select('*')
            ->where('store_id', '=', $store_id)
            ->where('id', '!=', $food_id)
            ->where('status', '=', Constants::FOOD_APPROVE)
            ->orderBy('id', 'DESC')
            ->take(Constants::DETAIL_FOOD_ITEM_SLIDER)
            ->get();
    }

    /**
     * get foods paging by store id
     * @param $store_id int
     * @return paging colection array
     */
    public static function get_foods_paging_by_store_id($store_id){
        return DB::table(Constants::FOODS)
                ->where('store_id', '=', $store_id)
                ->where('status', '=', Constants::FOOD_APPROVE)
                ->orderBy('id', 'desc')
                ->paginate(Constants::DETAIL_STORE_FOODS_PAGING);
    }


    /**
     * get 6 foods different store in page detail food. 
     * @return object Collection
     */
    public static function get_foods_different_store_by_categorys($food_id, $store_id, $arrCategory) {
        return DB::table(Constants::FOODS. ' as f')
            ->select('f.*', 'u.name as username', 'u.image as img_user')
            ->join(Constants::FOODS_CATEGORIES. ' as fc', 'fc.food_id', '=', 'f.id')
            ->join(Constants::STORES . ' as s', 's.id', '=', 'f.store_id')
            ->join(Constants::STORES_USERS . ' as su', 'su.store_id', '=', 's.id')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'su.user_id')
            ->where('f.store_id', '!=', $store_id)
            ->where('f.id', '!=', $food_id)
            ->whereIn('fc.category_id', $arrCategory)
            ->orderBy('f.id', 'DESC')
            ->take(Constants::DETAIL_FOOD_ITEM_FOOD_DIFFERENT_STORE)
            ->get();
    }
    /**
     * get 6 food different store in page detail food by tag
     * @param food id, store id, array tag
     * @return object Collection
     */
    public static function get_foods_different_store_by_tag($food_id, $store_id, $arrTag) {
        return DB::table(Constants::FOODS. ' as f')
            ->select('f.*', 'u.name as username', 'u.image as img_user')
            ->join(Constants::FOODS_TAGS. ' as ft', 'ft.food_id', '=', 'f.id')
            ->join(Constants::STORES . ' as s', 's.id', '=', 'f.store_id')
            ->join(Constants::STORES_USERS . ' as su', 'su.store_id', '=', 's.id')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'su.user_id')
            ->where('f.store_id', '!=', $store_id)
            ->where('f.id', '!=', $food_id)
            ->where('f.status', '=', Constants::FOOD_APPROVE)
            ->whereIn('ft.tag_id', $arrTag)
            ->orderBy('f.id', 'DESC')
            ->take(Constants::DETAIL_FOOD_ITEM_FOOD_DIFFERENT_STORE)
            ->get();
    }

    /**
     * count all food
     * @return object Collection
     */
    public static function count_rows(){
        return DB::table(Constants::FOODS)
            ->count();
    }

    /**
     * count food by tags
     * @return object Collection
     */
    public static function count_rows_by_tag_slug($tag_slug){
        return DB::table(Constants::FOODS. ' as f')
            ->join(Constants::FOODS_TAGS. ' as ft', 'ft.tag_id', '=', 'f.id')
            ->join(Constants::TAGS. ' as t', 't.id', '=', 'ft.tag_id')
            ->where('t.slug', 'like', $tag_slug)
            ->count();
    }

    /**
     * count food by store id
     * @return object Collection
     */
    public static function count_food_by_store_id($store_id) {
        return DB::table(Constants::FOODS)
                ->where('store_id', '=', $store_id)
                ->count();
    }

    /**
     * get foods for load more
     * @param $food_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function get_foods_load_more($food_start_id, $offset, $limit){
        return DB::table(Constants::FOODS . ' as f')
            ->join(Constants::STORES . ' as s', 's.id', '=', 'f.store_id')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
            ->select('f.*', 'u.name as user_name', 'u.image as user_image', 'u.id as user_id', 'u._follow as user_follow')
            ->where([
                        ['f.status', '=', Constants::FOOD_APPROVE],
                        ['f.id', '<', $food_start_id],
                    ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy('f.id', 'DESC')
            ->get();
    }

    /**
     * get foods by tag slug
     * @return object Collection
     */
    public static function get_foods_by_tag_slug($tag_slug) {
        return DB::table(Constants::FOODS. ' as f')
            ->select('f.id', 'f.name', 'f.images', 'f.detail', 'f.slug', 'f.price', 'f.price_max', 'f.guides', 'f.videos', 'f.steps', 'f.store_id')
            ->join(Constants::FOODS_TAGS. ' as ft', 'ft.food_id', '=', 'f.id')
            ->join(Constants::TAGS. ' as t', 't.id', '=', 'ft.tag_id')
            ->where('t.slug', 'like', $tag_slug)
            ->limit(Constants::HOME_MAIN_FOOD_ITEMS)
            ->get();
    }
    
    /**
     * get food by store id
     * @return object Collection
     */
    public static function get_foods_by_store_id($store_id) {
        return DB::table(Constants::FOODS. ' as f')
            ->select('*')
            ->where('f.store_id', '=', $store_id)
            ->orderBy('f.id', 'DESC')
            ->get();

    }

    /**
     * get list food by tag slug
     * @return object Collection
     */
    public static function get_food_by_tag_slug($arr_slug_tag) {
        return DB::table(Constants::FOODS. ' as f')
            ->join(Constants::FOODS_TAGS. ' as ft', 'ft.food_id', '=', 'f.id')
            ->join(Constants::TAGS. ' as t', 't.id', '=', 'ft.tag_id')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
            ->where('f.status', '=', Constants::FOOD_APPROVE)
            ->select('f.*', 't.name as name_tag', 't.slug as slug_tag', 'u.image as user_image', 'u.name as user_name', 'u.id as user_id', 'u._follow as user_follow')
            ->whereIn('t.slug', $arr_slug_tag)
            ->get();
    }
    
    /**
     * get list food by name food
     * @return object Collection
     */
    public static function get_foods_by_name_food($name_food) {
        return DB::table(Constants::FOODS. ' as f')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
            ->select('f.*', 'u.id as user_id', 'u.name as user_name', 'u.image as user_image')
            ->where('f.name', 'like', '%'.$name_food.'%')
            ->where('f.status', '=', Constants::FOOD_APPROVE)
            ->get();
    }

    /**
     * get list food by category slug
     * @return object Collection
     */
    public static function get_foods_by_category_slug($category_slug) { 
        return DB::table(Constants::FOODS. ' as f')
        ->select('f.*', 'u.image as user_image', 'u.name as user_name', 'u.id as user_id', 'u._follow as user_follow')
        ->join(Constants::FOODS_CATEGORIES. ' as fc', 'fc.food_id', '=', 'f.id')
        ->join(Constants::CATEGORIES. ' as cat', 'cat.id', '=', 'fc.category_id')
        ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
        ->where('cat.slug', 'like', $category_slug)
        ->where('f.status', '=', Constants::FOOD_APPROVE)
        ->get();
    }

    /**
     * get list food by name food (search page)
     * @param $name string, $limit int
     * @return object Collection
     */
    public static function search_food_by_name($name, $limit) {
        return DB::table(Constants::FOODS . ' as f')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
            ->select('f.*', 'u.name as user_name', 'u.image as user_image', 'u.id as user_id', 'u._follow as user_follow')
            ->where('f.name', 'like', '%' . $name . '%')
            ->where('f.status', '=', Constants::FOOD_APPROVE)
            ->limit($limit)
            ->orderBy('f.id', 'DESC')
            ->get();
    }

    /**
     * get foods for load more (search page)
     * @param $name string, $food_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function search_foods_by_name_load_more($name, $food_start_id, $offset, $limit) {
        return DB::table(Constants::FOODS . ' as f')
            ->join(Constants::USERS . ' as u', 'u.id', '=', 'f.user_id')
            ->select('f.*', 'u.name as user_name', 'u.image as user_image', 'u.id as user_id')
            ->where([
                        ['status', '=', Constants::FOOD_APPROVE],
                        ['f.id', '<', $food_start_id],
                        ['f.name', 'like', '%' . $name . '%'],
                    ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy('f.id', 'DESC')
            ->get();
    }

    /**
     * get foods by tag slug, id store
     * @return object Collection
     */
    public static function get_foods_by_store_id_tag_slug($store_id, $tag_slug) {
        return DB::table(Constants::FOODS . ' as f')
            ->select('f.id', 'f.name', 'f.images', 'f.detail', 'f.slug', 'f.price', 'f.price_max', 'f.guides', 'f.videos', 'f.steps', 'f.store_id')
            ->join(Constants::FOODS_TAGS . ' as ft', 'ft.food_id', '=', 'f.id')
            ->join(Constants::TAGS . ' as t', 't.id', '=', 'ft.tag_id')
            ->where([
                        ['t.slug', 'like', $tag_slug],
                        ['f.store_id', '=', $store_id],
                    ])
            ->limit(Constants::HOME_MAIN_FOOD_ITEMS)
            ->get();
    }

    /**
     * get foods created at null
     * @return object Collection Food
     */
    public static function get_foods_created_at_null() {
        return DB::table(Constants::FOODS)
                ->select('id','name')
                ->where('created_at',null)
                ->get();
    }

    /**
     * get foods like by user id
     * @param user_id
     * @return array foods
     */
    public static function get_like_foods_by_user_id($user_id) {
        return DB::table(Constants::FOODS . ' as f')
                ->join(Constants::FOODS_LIKES . ' as fl', 'fl.food_id', '=', 'f.id')
                ->where('fl.user_id', $user_id)
                ->select('f.id','fl.user_id')
                ->get()
                ->toArray();
    }

    /**
     * get foods approve
     * @return object Collection
     */
    public static function get_foods($offset, $limit) {
        return DB::table(Constants::FOODS . ' as f')
                ->select('f.id', 'f.slug', 'f.images', 'f.name as food_name', 'f.detail')
                ->where('status', '=', Constants::FOOD_APPROVE)
                ->orderBy('f.id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->toArray();
    }

    /**
     * count foods approve
     * @return int
     */
    public static function count_foods() {
        return DB::table(Constants::FOODS)
                ->where('status', '=', Constants::FOOD_APPROVE)
                ->count();
    }
}
