<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class FoodCommentQModel extends Model {
	/**
	 * get food_comment by food_id and user_id
	 * @param food_id, user_id
	 * @return object collection
	 */
	public static function get_food_comment($food_id, $user_id) {
		return DB::table(Constants::FOODS_COMMENTS)
				->where([
					['food_id', $food_id],
					['user_id', $user_id],
				])
				->first();
	}

	/**
	 * get food comment by food id
	 * @param food_id
	 * @return array
	 */
	public static function get_food_comments_by_food_id($food_id) {
		return DB::table(Constants::FOODS_COMMENTS . ' as fc')
				->join(Constants::USERS . ' as u', 'u.id', '=', 'fc.user_id')
				->where('food_id',$food_id)
				->select('fc.*', 'u.id as user_id', 'u.name as user_name', 'u.image as user_image', 'u._follow as user_follow')
				->take(4)
				->orderBy('fc.id', 'DESC')
				->get()
				->toArray();
	}
}