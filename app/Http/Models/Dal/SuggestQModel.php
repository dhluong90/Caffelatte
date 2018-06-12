<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuggestQModel extends Model
{

    /**
     * get_passed_by_user_id
     * @param $user_id
     * @return user
     */
    public static function get_passed_by_user_id($user_id) {
        return DB::table('suggests')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->where('status', config('constant.suggest.status.passed'))
            ->get();
    }

    /**
     * get_unmatch_by_user_id
     * @param $user_id
     * @return user
     */
    public static function get_unmatch_by_user_id($user_id) {
        return DB::table('suggests')
            ->select('*')
            ->where(function($query) use ($user_id) {
                $query->where('user_id', '=', $user_id)
                    ->orWhere('matching_id', '=', $user_id);
            })
            ->where('status', config('constant.suggest.status.approved'))
            ->first();
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
    public static function get_users_by_status($user_id, $status, $suggest_at = null) {
        $query = DB::table('customers as u')
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
     * get_list_user_by_status
     * @param $user_id
     * @return user
     */
    public static function get_users_like_me($user_id, $limit = null) {
        $query = DB::table('customers as u')
                ->select('u.*', 's.status')
                ->join('suggests as s', 's.user_id', '=', 'u.id')
                ->where('s.matching_id', '=', $user_id)
                ->where('s.status', '=', config('constant.suggest.status.liked'));

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * get_current_suggest
     * @param $user_id
     * @param $status array
     * @param $suggest_at
     * @return user
     */
    public static function get_current_suggest($user_id, $suggest_list, $suggest_at, $limit) {
        $suggests = [];

        // get user like me in $suggest_list
        $users_like_me = DB::table('customers as u')
                ->select('u.*', 's.status')
                ->join('suggests as s', 's.user_id', '=', 'u.id')
                ->where('s.matching_id', '=', $user_id)
                ->where('s.status', '=', config('constant.suggest.status.liked'))
                ->whereIn('u.id', $suggest_list)
                ->limit($limit)
                ->get();

        foreach ($users_like_me as $item) {
            array_push($suggests, $item);
        }

        if (count($suggests) < $limit) {
            // get suggest me today
            $users_suggest_me = DB::table('customers as u')
                    ->select('u.*', 's.status')
                    ->join('suggests as s', 's.matching_id', '=', 'u.id')
                    ->where('s.user_id', '=', $user_id)
                    ->where('s.status', '=', config('constant.suggest.status.suggested'))
                    ->where('s.created_at', '=', $suggest_at)
                    ->whereIn('u.id', $suggest_list)
                    ->limit($limit - count($suggests))
                    ->get();

            foreach ($users_suggest_me as $item) {
                array_push($suggests, $item);
            }
        }

        return $suggests;
    }

    /**
     * get_new_suggest
     * @param $user object
     * @param $person_friends array
     * @param $suggests array
     * @return user
     */
    public static function get_new_suggest($user, $person_friends, $suggests) {
        $friends = $user->_friend ? json_decode($user->_friend) : [];

        // get all user matching from table suggest
        $user_matching_ids = self::get_list_matching($user->id);

        $suggested_ids = [];
        foreach ($suggests as $item) {
            array_push($suggested_ids, $item->id);
        }

        $result = DB::table('customers')
            ->select('*')
            ->where('id', '!=', $user->id)
            ->where(function($query) use ($user) {
                $query->where('gender', '!=', $user->gender)
                ->orWhere('gender', '=', null);
            })
            ->where('country', '=', $user->country)
            ->whereIn('facebook_id', $person_friends)
            ->whereNotIn('id', $suggested_ids)
            ->whereNotIn('facebook_id', $friends)
            ->whereNotIn('id', $user_matching_ids)
            ->limit(config('constant.suggest.limit') - count($suggests))
            ->get();

        return $result;
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
        // case 1
        $list = DB::table('suggests')
            ->select('matching_id')
            ->where('user_id', '=', $user_id)
            ->get();

        foreach ($list as $item) {
            array_push($result, $item->matching_id);
        }

        // case 2
        $list = DB::table('suggests')
            ->select('user_id')
            ->where('matching_id', '=', $user_id)
            ->get();

        foreach ($list as $item) {
            array_push($result, $item->user_id);
        }

        return $result;
    }
}