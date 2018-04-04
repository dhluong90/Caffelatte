<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class TagCModel extends Model
{
    /**
     * insert tag
     * @param array data
     * @return boolean
     */
    public static function insert_tag($data) {
        return DB::table(Constants::TAGS)->insert($data);
    }

    /**
     * update tag
     * @param id
     * @param array data
     * @return boolean
     */
    public static function update_tag($id, $data) {
        return DB::table(Constants::TAGS)
                ->where('id', $id)
                ->update($data);
    }
    /**
     * delete a tag
     * @param id
     * @return boolean
     */
    public static function delete_tag($id) {
        return DB::table(Constants::TAGS)
            ->where('id', '=', $id)
            ->delete();
    }
}
