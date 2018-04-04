<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreLikeCModel extends Model
{
	/**
     * insert store like record
     * @param array data
     * @return boolean
     */
    public static function insert_store_like($data) {
        return DB::table(Constants::STORES_LIKES)->insertGetId($data);
    }

    /**
     * delete store like
     * @param id
     * @return boolean
     */
    public static function delete_store_like($id) {
        return DB::table(Constants::STORES_LIKES)
                ->where('id', $id)
                ->delete();
    }
}