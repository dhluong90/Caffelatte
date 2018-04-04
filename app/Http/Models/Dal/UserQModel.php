<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class UserQModel extends Model
{
    /**
     * get all users id
     * @return id
     */
    public static function get_users_id() {
        return DB::table(Constants::USERS)
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
        $result = DB::table(Constants::USERS)
                ->where('id', '=', $user_id)
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }
        return $result[0];
    }

    /**
     * get user by username
     * @param $username
     * @return object|boolean : all properties from `users` table,
     * returns false if no user is founded
     */
    public static function get_user_by_username($username) {
        $result = DB::table(Constants::USERS)
            ->where('email', '=', $username)
            ->get();

        if (empty($result[0])) {
            return FALSE;
        }

        return $result[0];
    }

    /**
     * search user paging
     * @param $email string 
     * @param $role int
     * @return array Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_user_paging($role, $email) {
        return DB::table(Constants::USERS .' as u')
                ->select('u.*')
                ->orderBy('u.id', 'desc')
                ->where('u.role', '=', $role)
                ->where('u.email', 'like', '%' . $email . '%')
                ->paginate(Constants::USER_DEFAULT_PAGING);
    }

    /**
     * get users to display at main content
     * @return object Collection
     */
    public static function get_users_for_main_content($limit) {
        return DB::table(Constants::USERS .' as u')
                ->select('u.*')
                ->orderBy('u.id', 'desc')
                ->where('u.role', '=', Constants::ROLES['member'])
                ->limit($limit)
                ->orderBy('u.id', 'DESC')
                ->get();
    }

    /**
     * get users for load more
     * @param $user_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function get_users_load_more($user_start_id, $offset, $limit){
        return DB::table(Constants::USERS .' as u')
                ->select('u.*')
                ->orderBy('u.id', 'desc')
                ->where([
                            ['u.role', '=', Constants::ROLES['member']],
                            ['u.id', '<', $user_start_id],
                        ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy('u.id', 'DESC')
                ->get();
    }

    /**
     * get list user by name or phone number or email
     * @param $search_string string
     * @return object Collection
     */
    public static function search_user_by_name_or_phone_or_email($search_string, $limit) {
        return DB::table(Constants::USERS. ' as u')
            ->select('u.*')
            ->where([
                        ['u.role', '=', Constants::ROLES['member']],
                        ['u.name', 'like', '%' . $search_string . '%'],
                    ])
            ->orWhere([
                        ['u.role', '=', Constants::ROLES['member']],
                        ['u.phone', 'like', '%' . $search_string . '%'],
                    ])
            ->orWhere([
                        ['u.role', '=', Constants::ROLES['member']],
                        ['u.email', 'like', '%' . $search_string . '%'],
                    ])
            ->limit($limit)
            ->orderBy('u.id', 'DESC')
            ->get();
    }

    /**
     * get list user by name or phone number or email for load more
     * @param $search_string string, $user_start_id int, $offset int, $limit int
     * @return object Collection
     */
    public static function search_user_by_name_or_phone_or_email_load_more($search_string, $user_start_id, $offset, $limit) {
        return DB::table(Constants::USERS . ' as u')
                ->select('u.id','u.name', 'u.email', 'u.image')
                ->where([
                            ['u.id', '<', $user_start_id],
                            ['u.role', '=', Constants::ROLES['member']],
                            ['u.name', 'like', '%' . $search_string . '%'],
                        ])
                ->orWhere([
                            ['u.id', '<', $user_start_id],
                            ['u.role', '=', Constants::ROLES['member']],
                            ['u.phone', 'like', '%' . $search_string . '%'],
                        ])
                ->orWhere([
                            ['u.id', '<', $user_start_id],
                            ['u.role', '=', Constants::ROLES['member']],
                            ['u.email', 'like', '%' . $search_string . '%'],
                        ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy('u.id', 'DESC')
                ->get();
    }

    /**
     * get user follow by user id
     * @param user_id
     * @return array food
     */
    public static function get_follow_user_by_user_id($user_id) {
        return DB::table(Constants::USERS . ' as u')
                ->join(Constants::USERS_FOLLOWS . ' as uf', 'uf.user_id', '=', 'u.id')
                ->where('uf.follower_id', $user_id)
                ->select('u.id','uf.user_id')
                ->get()
                ->toArray();
    }

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
}