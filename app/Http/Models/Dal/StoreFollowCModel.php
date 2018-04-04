<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreFollowCModel extends Model
{
	/**
     * insert store follow record
     * @param array data
     * @return boolean
     */
    public static function insert_store_follow($data) {
        return DB::table(Constants::STORES_FOLLOWS)->insertGetId($data);
    }

    /**
     * delete store follow
     * @param id
     * @return boolean
     */
    public static function delete_store_follow($id) {
        return DB::table(Constants::STORES_FOLLOWS)
                ->where('id', $id)
                ->delete();
    }
}