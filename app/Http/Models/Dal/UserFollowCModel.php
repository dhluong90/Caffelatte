<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class UserFollowCModel extends Model
{
	/**
     * insert user follow record
     * @param array data
     * @return boolean
     */
    public static function insert_user_follow($data) {
        return DB::table(Constants::USERS_FOLLOWS)->insertGetId($data);
    }

    /**
     * delete user follow
     * @param id
     * @return boolean
     */
    public static function delete_user_follow($id) {
        return DB::table(Constants::USERS_FOLLOWS)
                ->where('id', $id)
                ->delete();
    }
}