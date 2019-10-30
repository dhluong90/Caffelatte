<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class CustomerQModel extends Model
{

    protected $table = 'customers';

    /**
     * get_user_by_facebook_id
     * @param $facebook_id
     * @return user
     */
    public static function get_user_by_facebook_id($facebook_id)
    {
        return DB::table('customers')
            ->select('*')
            ->where('facebook_id', '=', $facebook_id)
            ->first();
    }

    /**
     * get_user_by_phone
     * @param $phone
     * @return user
     */
    public static function get_user_by_phone($phone)
    {
        return DB::table('customers')
            ->select('*')
            ->where('phone', '=', $phone)
            ->first();
    }

    /**
     * get_users_by_facebooks
     * @param $facebooks array
     * @return user
     */
    public static function get_users_by_facebooks($facebooks)
    {
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
    public static function get_user_by_token($token)
    {
        return DB::table('customers')
            ->select('*')
            ->where('token', '=', $token)
            ->first();
    }

    /**
     * get all users id
     * @return id
     */
    public static function get_users_id()
    {
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
    public static function get_user_by_id($user_id)
    {
        return DB::table('customers')->select('*')->selectRaw("ROUND(DATE_PART('day', NOW() - TO_DATE( birthday , 'DD-MM-YYYY' ))/365.25) as age")
            ->where('id', '=', $user_id)
            ->first();
    }

    /**
     * search user paging
     * @param $email string
     * @param $role int
     * @return array Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search_user_paging($email)
    {
        return DB::table('customers' . ' as c')
            ->select('c.*')->selectRaw("ROUND(DATE_PART('day', NOW() - TO_DATE( birthday , 'DD-MM-YYYY' ))/365.25) as age")
            ->orderBy('c.id', 'desc')
            ->where('c.name', 'like', '%' . $email . '%')
            ->paginate(10);
    }

    /**
     * search user paging
     * @param $email string
     * @param $role int
     * @return array Illuminate\Pagination\LengthAwarePaginator
     */
    public static function get_all_user()
    {
        return DB::table('customers' . ' as c')
            ->select('c.*')
            ->orderBy('c.id', 'desc')
            ->get()->toArray();
    }

    /**
     * get all customer
     * @return id
     */
    public static function get_users_fcm_token()
    {
        return DB::table('customers')
            ->select('fcm_token', 'language')
            ->where('fcm_token', '!=', NUll)
            ->where('fcm_token', '!=', '')
            ->get();
    }

    /**
     * @param null $lang
     * @param array $country
     * @return mixed
     */
    public static function get_users_fcm_token_with_language_and_country($lang = null, $country = [])
    {

        $query = DB::table('customers')
            ->select('fcm_token', 'language')
            ->where('fcm_token', '!=', NUll)
            ->where('fcm_token', '!=', '');
        if ($lang) {
            $query = $query->where('language', $lang);
        }
        if ($country) {
            $query = $query->where('country', $country);
        }
        return $query
            ->get();
    }

    public static function get_users_by_chat_id($listId)
    {
        return DB::table('customers')
            ->whereIn('chat_id', $listId)
            ->get();
    }

    public static function get_users_by_firebase_uid($listId)
    {
        return DB::table('customers')
            ->whereIn('firebase_uid', $listId)
            ->get();
    }

    public static function get_user_by_share_link_id($link_id)
    {
        return DB::table('customers')->where('share_link_id', '=', $link_id)->first();
    }
}