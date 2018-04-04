<?php

namespace App\Http\Models\dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;


class StoreCModel extends Model
{
    /**
     * insert store
     * @param array $data
     * @return id
     */
    public static function insert_store($data) {
        return DB::table(Constants::STORES)->insertGetId($data);
    }

    /**
     * delete a store
     * @param $id int
     * @return boolean
     */
    public static function delete_store($id) {
        return DB::table(Constants::STORES)
            ->where('id', '=', $id)
            ->delete();
    }

    /**
     * update store
     * @param $store_id int
     * @param $data array
     * @return boolean
     */
    public static function update_store($store_id, $data) {
        return DB::table(Constants::STORES)
                ->where('id', '=', $store_id)
                ->update($data);
    }
}
