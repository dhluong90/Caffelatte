<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreUserQModel extends Model
{
	/**
     * count stores by user_id
     * @param user_id
     * @return object|boolean : all properties from `users` table,
     * returns false if no products is founded
     */
    public static function count_stores_by_user_id($user_id) {
        return DB::table(Constants::STORES_USERS)
                ->where('user_id', '=', $user_id)
                ->count(DB::raw('DISTINCT store_id'));
    }

    /**
     * check store of user
     * @param store_id
     * @param user_id
     * @return boolean
     */
    public static function check_mystore($store_id, $user_id) {
        $result = DB::table(Constants::STORES_USERS)
                ->where([
                    ['store_id', '=', $store_id],
                    ['user_id', '=', $user_id],
                ])
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * select list store id by user id
     * @param user_id
     * @return boolean
     */
    public static function get_stores_id_by_user_id($user_id) {
        return DB::table(Constants::STORES_USERS)
                ->select('store_id')
                ->where('user_id', $user_id)
                ->get();
    }

}
