<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class FoodLikeQModel extends Model {
	/**
	 * get food_like by food_id and user_id
	 * @param food_id, user_id
	 * @return object collection
	 */
	public static function get_food_like($food_id, $user_id) {
		return DB::table(Constants::FOODS_LIKES)
				->where([
					['food_id', $food_id],
					['user_id', $user_id],
				])
				->first();
	}
	
}