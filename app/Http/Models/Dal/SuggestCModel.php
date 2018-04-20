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
    public static function create($data) {
        return DB::table('suggests')->insertGetId($data);
    }

    /**
     * update
     * @param user_id int
     * @param array data
     * @return id
     */
    public static function update($suggest_id, $data) {
        return DB::table('suggests')
                ->where('id', '=', $suggest_id)
                ->update($data);
    }
}