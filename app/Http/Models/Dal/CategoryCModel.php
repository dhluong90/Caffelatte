<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class CategoryCModel extends Model
{
    /**
     * insert category
     * @param array data
     * @return boolean
     */
    public static function insert_category($data) {
        return DB::table(Constants::CATEGORIES)->insert($data);
    }

    /**
     * update category
     * @param id
     * @param array data
     * @return boolean
     */
    public static function update_category($id, $data) {
        return DB::table(Constants::CATEGORIES)
                ->where('id', '=', $id)
                ->update($data);
    }

    /**
     * delete a category
     * @param id
     * @return boolean
     */
    public static function delete_category($id) {
        return DB::table(Constants::CATEGORIES)
            ->where('id', '=', $id)
            ->delete();
    }
}
