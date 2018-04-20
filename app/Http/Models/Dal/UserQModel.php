<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class UserQModel extends Model
{

    /**
     * get_user_by_facebook_id
     * @param $facebook_id
     * @return user
     */
    public static function get_user_by_facebook_id($facebook_id) {
        return DB::table('users')
            ->select('*')
            ->where('facebook_id', '=', $facebook_id)
            ->first();
    }

    /**
     * get_user_by_token
     * @param $facebook_id
     * @return user
     */
    public static function get_user_by_token($token) {
        return DB::table('users')
            ->select('*')
            ->where('token', '=', $token)
            ->first();
    }

    /**
     * get all users id
     * @return id
     */
    public static function get_users_id() {
        return DB::table('users')
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
        return DB::table('users')
                ->where('id', '=', $user_id)
                ->first();
    }

    /**
     * get user by username
     * @param $username
     * @return object|boolean : all properties from `users` table,
     * returns false if no user is founded
     */
    public static function get_user_by_username($username) {
        return DB::table('users')
            ->where('email', '=', $username)
            ->first();
    }

    /**
     * search user paging
     * @param $email string 
     * @param $role int
     * @return array Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_user_paging($role, $email) {
        return DB::table('users' .' as u')
                ->select('u.*')
                ->orderBy('u.id', 'desc')
                ->where('u.role', '=', $role)
                ->where('u.email', 'like', '%' . $email . '%')
                ->paginate(10);
    }
}