<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuggestQModel extends Model
{

    /**
     * get_passed_by_user_id
     * @param $facebook_id
     * @return user
     */
    public static function get_passed_by_user_id($user_id) {
        return DB::table('suggests')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->get();
    }

    /**
     * get_list
     * @param $user_id
     * @param $status array
     * @return user
     */
    public static function get_list_by_status($user_id, $status) {
        return DB::table('suggests')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->whereIn('status', $status)
            ->get();
    }

    /**
     * get_list_user_by_status
     * @param $user_id
     * @param $status array
     * @param $suggest_at
     * @return user
     */
    public static function get_list_user_by_status($user_id, $status, $suggest_at = null) {
        $query = DB::table('users as u')
                ->select('u.*')
                ->join('suggests as s', 's.matching_id', '=', 'u.id')
                ->where('s.user_id', '=', $user_id)
                ->whereIn('s.status', $status);

        if ($suggest_at) {
            $query->where('s.created_at', '=', $suggest_at);
        }

        return $query->get();
    }

    /**
     * get_record_by_status
     * @param $user_id
     * @param $matching_id
     * @param $status
     * @return user
     */
    public static function get_record_by_status($user_id, $matching_id, $status) {
        return DB::table('suggests')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->where('matching_id', '=', $matching_id)
            ->where('status', $status)
            ->first();
    }

    /**
     * get_list
     * @param $user_id
     * @return user
     */
    public static function get_list_matching($user_id) {
        $result = [];
        $list = DB::table('suggests')
            ->select('matching_id')
            ->where('user_id', '=', $user_id)
            ->get();

        foreach ($list as $item) {
            array_push($result, $item->matching_id);
        }

        return $result;
    }
}