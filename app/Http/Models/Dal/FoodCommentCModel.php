<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class FoodCommentCModel extends Model
{
	/**
     * insert food comment record
     * @param array data
     * @return boolean
     */
    public static function insert_food_comment($data) {
        return DB::table(Constants::FOODS_COMMENTS)->insertGetId($data);
    }

    /**
     * delete food comment
     * @param id
     * @return boolean
     */
    public static function delete_food_comment($id) {
        return DB::table(Constants::FOODS_COMMENTS)
                ->where('id', $id)
                ->delete();
    }
}
