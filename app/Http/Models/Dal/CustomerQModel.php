<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class CustomerQModel extends Model
{

    /**
     * get_user_by_facebook_id
     * @param $facebook_id
     * @return user
     */
    public static function get_user_by_facebook_id($facebook_id) {
        return DB::table('customers')
            ->select('*')
            ->where('facebook_id', '=', $facebook_id)
            ->first();
    }

    /**
     * get_users_by_facebooks
     * @param $facebooks array
     * @return user
     */
    public static function get_users_by_facebooks($facebooks) {
        return DB::table('customers')
            ->select('*')
            ->whereIn('facebook_id', $facebooks)
            ->get();
    }

    /**
     * get_user_by_token
     * @param $facebook_id
     * @return user
     */
    public static function get_user_by_token($token) {
        return DB::table('customers')
            ->select('*')
            ->where('token', '=', $token)
            ->first();
    }

    /**
     * get all users id
     * @return id
     */
    public static function get_users_id() {
        return DB::table('customers')
                ->select('id')
                ->get();
    }

    /**
     * get user by user_id
     * @param user_id
     * @return object|boolean : all properties from `users` table,
     * returns false if no products is founded
     */
    public static function get_user_by_id($user_id) {
        return DB::table('customers')
                ->where('id', '=', $user_id)
                ->first();
    }

    /**
     * search user paging
     * @param $email string 
     * @param $role int
     * @return array Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_user_paging($email) {
        return DB::table('customers' .' as c')
                ->select('c.*')
                ->orderBy('c.id', 'desc')
                ->where('c.name', 'like', '%' . $email . '%')
                ->paginate(10);
    }

    /**
     * get all customer
     * @return id
     */
    public static function get_users_fcm_token() {
        return DB::table('customers')
                ->select('fcm_token')
                ->where('fcm_token', '!=', NUll)
                ->get()
                ->toArray();
    }

    public static function get_users_by_chat_id ($listId) {
        return DB::table('customers')
            ->whereIn('chat_id', $listId)
            ->get();
    }
}