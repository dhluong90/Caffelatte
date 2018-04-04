<?php

namespace App\Http\Models\dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreQModel extends Model
{
	/**
     * get store by id
     * @param $id int
     * @return object|boolean : all properties from `stores` table,
     * returns false if no stores is founded
     */
    public static function get_store_by_id($id) {
        $result = DB::table(Constants::STORES)
                ->where('id', '=', $id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * get store by store_id
     * @param int $store_id
     * @return object|boolean : all properties from `stores` table,
     * returns false if no stores is founded
     */
    public static function get_store_by_store_id($store_id) {
        $result = DB::table(Constants::STORES . ' as s')
                ->select('s.*', 'su.user_id')
                ->join(Constants::STORES_USERS . ' as su', 's.id', '=', 'su.store_id')
                ->where('s.id', '=', $store_id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * Get approved stores paging
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function get_approved_stores_paging() {
        return DB::table(Constants::STORES)
                ->where('status', '=', Constants::STORE_APPROVE)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING)->setPath ( '' );
    }   

    /**
     * Search approved stores paging
     * @param $search string
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_approved_stores_paging($search) {
        return DB::table(Constants::STORES)
                ->where('name', 'like', '%'.$search.'%') 
                ->where('status', '=', Constants::STORE_APPROVE)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    } 

    /**
     * Get pending stores paging
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function get_pending_stores_paging() {
        return DB::table(Constants::STORES)
                ->where('status', '=', Constants::STORE_PENDING)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    } 

    /**
     * Search pending stores paging
     * @param $search string
     * @return object Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_pending_stores_paging($search) {
        return DB::table(Constants::STORES)
                ->where('name', 'like', '%'.$search.'%') 
                ->where('status', '=', Constants::STORE_PENDING)
                ->orderBy('id', 'desc')
                ->paginate(Constants::ADMIN_DEFAULT_PAGING);
    }

    /**
     * get stores to display at main content
     * @return object Collection
     */
    public static function get_stores_for_main_content($limit) {
        return DB::table(Constants::STORES . ' as s')
                ->select('s.*')
                ->where('status', '=', Constants::STORE_APPROVE)
                ->orderBy('s.id', 'desc')
                ->limit($limit)
                ->get();
    }

    /**
     * get stores to display at main content by user id
     * @return object Collection
     */
    public static function get_list_store_by_user_id($user_id) {
        return DB::table(Constants::STORES . ' as s')
                ->select('s.id', 's.name', 's.address', 's.introduction')
                ->join(Constants::STORES_USERS. ' as su', 'su.store_id', '=', 's.id')
                ->join(Constants::USERS. ' as u', 'su.user_id', '=', 'u.id')
                ->where('u.id', '=', $user_id)
                ->orderBy('s.id', 'DESC')
                ->get()
                ->toArray();
    }

    /**
     * count all store
     * @return object Collection
     */
    public static function count_rows(){
        return DB::table(Constants::STORES)
            ->count();
    }

    /**
     * get stores by counted
     * @param $last_store_id int
     * @return object Collection
     */
    public static function get_stores_by_count($last_store_id) {
        if($last_store_id < constants::HOME_MAIN_STORE_ITEMS) {
            return DB::table(Constants::STORES)
            ->select('*')
            ->where('id', '<', $last_store_id)
            ->limit($last_store_id)
            ->orderBy('id', 'DESC')
            ->get();
        } else {
            return DB::table(Constants::STORES)
                ->select('*')
                ->where('id', '<', $last_store_id)
                ->limit(Constants::HOME_MAIN_STORE_ITEMS)
                ->orderBy('id', 'DESC')
                ->get();
        }
    }

    /**
     * get stores for load more
     * @param $store_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function get_stores_load_more($store_start_id, $offset, $limit){
        return DB::table(Constants::STORES)
            ->select('*')
            ->where('status', '=', Constants::STORE_APPROVE)
            ->where('id', '<', $store_start_id)
            ->offset($offset)
            ->limit($limit)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * get stores to display at manage profile
     * @return object Collection
     */
    public static function get_stores_by_user_id($user_id) {
        return DB::table(Constants::STORES . ' as s')
                ->select('s.*')
                ->join(Constants::STORES_USERS. ' as su', 'su.store_id', '=', 's.id')
                ->where('su.user_id', '=', $user_id)
                ->orderBy('su.store_id', 'DESC')
                ->get();
    }
    
    /**
     * get list stores by name store (search page)
     * @param $name
     * @return object Collection
     */
    public static function search_store_by_name($name, $limit) {
        return DB::table(Constants::STORES. ' as s')
            ->select('*')
            ->where('s.name', 'like', '%'.$name.'%')
            ->where('s.status', '=', Constants::STORE_APPROVE)
            ->limit($limit)
            ->orderBy('s.id', 'DESC')
            ->get();
    }

    /**
     * get stores for load more (search page)
     * @param $name string, $store_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function search_store_by_name_load_more($name, $store_start_id, $offset, $limit){
        return DB::table(Constants::STORES)
            ->select('*')
            ->where([
                        ['status', '=', Constants::STORE_APPROVE],
                        ['id', '<', $store_start_id],
                        ['name', 'like', '%' . $name . '%'],
                    ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * get stores create_at null
     * @return object Collection Store
     */
    public static function get_stores_created_at_null() {
        return DB::table(Constants::STORES)
                ->select('id','name')
                ->where('created_at', null)
                ->get();
    }

    /**
     * get store like by user id
     * @param user_id
     * @return array
     */
    public static function get_like_stores_by_user_id($user_id) {
        return DB::table(Constants::STORES . ' as s')
                ->join(Constants::STORES_LIKES . ' as sl', 'sl.store_id', '=', 's.id')
                ->where('sl.user_id', $user_id)
                ->select('s.id', 'sl.user_id')
                ->get()
                ->toArray();
    }

    /**
     * get store like by user id
     * @param user_id
     * @return array
     */
    public static function get_follow_stores_by_user_id($user_id) {
        return DB::table(Constants::STORES . ' as s')
                ->join(Constants::STORES_FOLLOWS . ' as sf', 'sf.store_id', '=', 's.id')
                ->where('sf.user_id', $user_id)
                ->select('s.id', 'sf.user_id')
                ->get()
                ->toArray();
    }

    /**
     * get stores approve
     * @return object Collection
     */
    public static function get_stores($offset, $limit) {
        return DB::table(Constants::STORES . ' as s')
                ->select('*')
                ->where('status', '=', Constants::STORE_APPROVE)
                ->orderBy('s.id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->toArray();
    }

    /**
     * count stores approve
     * @return int
     */
    public static function count_stores() {
        return DB::table(Constants::STORES)
                ->where('status', '=', Constants::STORE_APPROVE)
                ->count();
    }
}
