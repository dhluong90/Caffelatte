<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreUserCModel extends Model
{
	/**
     * insert store user
     * @param array data
     * @return boolean
     */
    public static function insert_store_user($data) {
        return DB::table(Constants::STORES_USERS)->insert($data);
    }
    /**
     * delete store user
     * @param id
     * @return boolean
     */
    public static function delete_store_user_by_store_id($store_id){
    	return DB::table(Constants::STORES_USERS)->where('store_id', $store_id)->delete();
    }
}
