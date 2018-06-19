<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuggestCModel extends Model
{

    /**
     * create
     * @param $facebook_id
     * @return id
     */
    public static function create_suggest($data) {
        return DB::table('suggests')->insert($data);
    }

    /**
     * update
     * @param suggest_id int
     * @param array data
     * @return id
     */
    public static function update_suggest($suggest_id, $data) {
        return DB::table('suggests')
                ->where('id', '=', $suggest_id)
                ->update($data);
    }

    /**
     * delete
     * @param suggest_id int
     * @return id
     */
    public static function delete_suggest($suggest_id) {
        return DB::table('suggests')
                ->where('id', '=', $suggest_id)
                ->delete();
    }

    /**
     * reset_suggest
     * @param user_id int
     * @return
     */
    public static function reset_suggest($user_id) {
        return DB::table('suggests')
                ->where('user_id', '=', $user_id)
                ->whereIn('status', [config('constant.suggest.status.suggested')])
                ->delete();
    }

    /**
     * reset_discover
     * @param user_id int
     * @return
     */
    public static function reset_discover($user_id) {
        return DB::table('suggests')
                ->where('user_id', '=', $user_id)
                ->whereIn('status', [config('constant.suggest.status.discover')])
                ->delete();
    }
}