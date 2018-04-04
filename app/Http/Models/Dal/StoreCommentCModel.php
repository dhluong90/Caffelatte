<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class StoreCommentCModel extends Model
{
	/**
     * insert store comment record
     * @param array data
     * @return boolean
     */
    public static function insert_store_comment($data) {
        return DB::table(Constants::STORES_COMMENTS)->insertGetId($data);
    }

    /**
     * delete store comment
     * @param id
     * @return boolean
     */
    public static function delete_store_comment($id) {
        return DB::table(Constants::STORES_COMMENTS)
                ->where('id', $id)
                ->delete();
    }
}
