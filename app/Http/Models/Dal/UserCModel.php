<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class UserCModel extends Model
{

    /**
     * sign_up
     * @param $data
     * @return id
     */
    public static function create_user($data) {
        return DB::table('users')->insertGetId($data);
    }

    /**
     * update user
     * @param user_id int
     * @param array data
     * @return boolean
     */
    public static function update_user($user_id, $data) {
        return DB::table('users')
                ->where('id', '=', $user_id)
                ->update($data);
    }

}
