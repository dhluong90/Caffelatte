<?php

namespace App\Http\Models\Dal;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuggestQModel extends Model
{

    /**
     * get_passed_by_user_id
     * @param $user_id
     * @return user
     */
    public static function get_passed_by_user_id($user_id)
    {
        return DB::table('suggests')
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->where('status', config('constant.suggest.status.passed'))
            ->get();
    }

    /**
     * get_unmatch_by_user_id
     * @param $user_id
     * @param $matching_id
     * @return user
     */
    public static function get_unmatch_by_user_id($user_id, $matching_id)
    {
        $sql = "select *
            from suggests
            where ((user_id = " . $user_id . " and matching_id = " . $matching_id . ") or 
                (user_id = " . $matching_id . " and matching_id = " . $user_id . "))
            and status = '" . config('constant.suggest.status.approved') . "'";
        $result = DB::select($sql);
        if ($result) {
            return $result[0];
        }
        return $result;
    }

    /**
     * get_list_unmatch_by_user_id
     * @param $user_id
     * @return user
     */
    public static function get_list_unmatch_by_user_id($user_id)
    {
        // case 1, user is user_id
        $list1 = DB::table('customers as u')
            ->select('u.*')
            ->join('suggests as s', 's.matching_id', '=', 'u.id')
            ->where('s.user_id', '=', $user_id)
            ->where('s.status', config('constant.suggest.status.unmatch'))
            ->get()
            ->toArray();

        // case 2, user is matching_id
        $list2 = DB::table('customers as u')
            ->select('u.*')
            ->join('suggests as s', 's.user_id', '=', 'u.id')
            ->where('s.matching_id', '=', $user_id)
            ->where('s.status', config('constant.suggest.status.unmatch'))
            ->get()
            ->toArray();
        $result = array_merge($list1, $list2);
        return $result;
    }

    /**
     * get_list_match_by_user_id
     * @param $user_id
     * @return user
     */
    public static function get_list_match_by_user_id($user_id)
    {
        // case 1, user is user_id
        $list1 = DB::table('customers as u')
            ->select('u.*')
            ->join('suggests as s', 's.matching_id', '=', 'u.id')
            ->where('s.user_id', '=', $user_id)
            ->where('s.status', config('constant.suggest.status.approved'))
            ->get()
            ->toArray();

        // case 2, user is matching_id
        $list2 = DB::table('customers as u')
            ->select('u.*')
            ->join('suggests as s', 's.user_id', '=', 'u.id')
            ->where('s.matching_id', '=', $user_id)
            ->where('s.status', config('constant.suggest.status.approved'))
            ->get()
            ->toArray();
        $result = array_merge($list1, $list2);
        return $result;
    }

    /**
     * get_list
     * @param $user_id
     * @param $status array
     * @return user
     */
    public static function get_list_by_status($user_id, $status)
    {
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
    public static function get_users_by_status($user_id, $status, $suggest_at = null)
    {
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
     * @param null $limit
     * @param user
     * @return user
     */
    public static function get_users_like_me($user_id, $limit = null, $user)
    {
        $selectWeightPoint = "((CASE WHEN u.city = '" . $user->city . "' THEN 3 ELSE 0 END)";
        if ($user->birthday) {
            $selectWeightPoint .= "  + (CASE WHEN EXTRACT(YEAR FROM TO_DATE(u.birthday, 'DD-MM-YYYY')) BETWEEN EXTRACT(YEAR FROM TO_DATE('" . $user->birthday . "', 'DD-MM-YYYY')) - 5 AND EXTRACT(YEAR FROM TO_DATE('" . $user->birthday . "', 'DD-MM-YYYY')) + 5 THEN 2 ELSE 0 END) ";
        }
        $selectWeightPoint .= "+ (CASE WHEN u.country = '" . $user->country . "' THEN 1 ELSE 0 END)) as weightPoint";
        $query = DB::table('customers as u')
            ->select('u.*', 's.status')
            ->selectRaw($selectWeightPoint)
            ->join('suggests as s', 's.user_id', '=', 'u.id')
            ->where('s.matching_id', '=', $user_id)
            ->where('u.gender', '<>', $user->gender)
            ->where('s.status', '=', config('constant.suggest.status.liked'))
            ->orderByRaw('"s"."updated_at" ASC')
            ->orderByRaw('weightPoint DESC');
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * get_current_suggest
     * @param $user_id
     * @param $limit
     * @return customer
     */
    public static function get_current_suggest($limit, $list_suggest, $user_id)
    {
        $array_reacted = [config('constant.suggest.status.passed'), config('constant.suggest.status.approved'), config('constant.suggest.status.liked'), 7];
        $str_reacted_status = implode(',', $array_reacted);
        $array_status_not_get = [ config('constant.suggest.status.discover')];
        $list_suggest = json_decode($list_suggest);
        if ($list_suggest) {
            $list_suggest_text = implode(',', $list_suggest);
        }
        return DB::table('customers as u')
                ->select('u.*')->selectRaw("CASE WHEN s.status IN (2,3,4,7) THEN 1 ELSE 0 END as reacted, array_position('{" . $list_suggest_text . "}', u.id) as suggested")
                ->join('suggests as s', 's.matching_id', '=', 'u.id')
                ->where('s.user_id', '=', $user_id)
                ->whereIn('u.id', $list_suggest)
                ->whereNotIn('s.status', $array_status_not_get)
                ->orderByRaw("suggested")
                ->limit($limit)
                ->groupBy("u.id")
                ->groupBy("s.status")
                ->get();
    }

    /**
     * get_new_suggest
     * @param $user object
     * @param $person_friends array
     * @param $suggests array
     * @return user
     */
    public static function get_new_suggest($user, $person_friends, $suggests)
    {
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
            ->where(function ($query) use ($user) {
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
    public static function get_record_by_status($user_id, $matching_id, $status, $limit = 3)
    {
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
    public static function get_list_matching($user_id)
    {
        $result = [];
        // case 1
        $list = DB::table('suggests')
            ->select('matching_id')
            ->where('user_id', '=', $user_id)
            ->where('status', '=', $user_id)
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

    /**
     * get_current_discover
     * @param $user_id
     * @param $reactingId
     * @param $listId
     * @return user
     */
    public static function get_current_discover($user_id, $reactingId ,$listId)
    {
        $strMatchingId = implode(',', $listId);
        $array_reacted = [config('constant.suggest.status.passed'), config('constant.suggest.status.approved'), config('constant.suggest.status.liked'), 7];
        $listReactedPrev = SuggestQModel::get_react_user($user_id);
        $listNotGet[] = $user_id;
        // get user like me in $suggest_list
        $list = DB::table('customers as u')
            ->select('u.*', 's.status', 's.created_at as s_created_at')->selectRaw("CASE WHEN 0 = 0 THEN FALSE END as reacted, array_position('{" . $strMatchingId . "}', u.id) as suggested")
            ->join('suggests as s', 's.matching_id', '=', 'u.id')
            ->where('s.user_id', '=', $user_id)
            ->whereIn('u.id', $listId)
            ->whereNotIn('u.id', $listReactedPrev)
            ->whereNotIn('u.id', $reactingId)
            ->whereNotIn('s.status', [config('constant.suggest.status.suggested')])
            ->limit(config('constant.suggest.limit'))
            ->orderByRaw("suggested")
            ->groupBy("u.id")
            ->groupBy("s.status")
            ->groupBy("s_created_at")
            ->get();
        foreach ($list as $k => $item) {
            if (in_array($item->id, $array_reacted) ) {
                $list[$k]->reacted = 1;
            } else {
                $list[$k]->reacted = 0;
            }
        }
        return $list;
    }

    /**
     * get_new_discover
     * @param $user object
     * @return users
     */
    public static function get_new_discover($user)
    {
        // get all user matching from table suggest
        $user_matching_ids = self::get_list_matching($user->id);
        $result = DB::table('customers')
            ->select('*')
            ->where('id', '!=', $user->id)
            ->where(function ($query) use ($user) {
                $query->where('gender', '!=', $user->gender)
                    ->orWhere('gender', '=', null);
            })
            ->where('country', '=', $user->country)
            ->whereNotIn('id', $user_matching_ids)
            ->orderBy(DB::raw('RANDOM()'))
            ->limit(config('constant.suggest.limit'))
            ->get();

        return $result;
    }

    public static function get_react_user($user_id)
    {
        $array_reacted = [config('constant.suggest.status.passed'), config('constant.suggest.status.approved'), config('constant.suggest.status.liked'), 7];
        $query = DB::table('customers as u')
            ->select('u.*', 's.status')
            ->join('suggests as s', 's.matching_id', '=', 'u.id')
            ->where('s.user_id', '=', $user_id)
            ->whereIn('s.status', $array_reacted);
        return $query->get()->pluck('id');
    }

    public static function get_reacted_user_in_day($user_id) {
        $current_time = time();
        $date = date('Y-m-d', $current_time);
        $array_reacted = [config('constant.suggest.status.passed'), config('constant.suggest.status.approved'), config('constant.suggest.status.liked')];
        $query = DB::table('customers as u')
            ->select('u.*', 's.status')
            ->join('suggests as s', 's.matching_id', '=', 'u.id')
            ->where('s.user_id', '=', $user_id)
            ->whereIn('s.status', $array_reacted)
            ->where('s.updated_at', $date)
            ->where('s.created_at', '=', Carbon::now()->format('Y-m-d'))
        ;
        $data = $query->get();
        if ($data) {
            $data = $data->pluck('id')->toArray();
        } else {
            $data = [];
        }

        return $data;
    }

}