<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class StoreLikeQModel extends Model {
	/**
	 * get store like by store_id and user_id
	 * @param store_id, user_id
	 * @return object collection
	 */
	public static function get_store_like($store_id, $user_id) {
		return DB::table(Constants::STORES_LIKES)
				->where([
					['store_id', $store_id],
					['user_id', $user_id],
				])
				->first();
	}
}