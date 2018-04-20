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
}