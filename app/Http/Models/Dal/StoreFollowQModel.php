<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class StoreFollowQModel extends Model {
	/**
	 * get store follow by user_id and store_id
	 * @param user_id, store_id
	 * @return object collection
	 */
	public static function get_store_follow($store_id, $user_id) {
		return DB::table(Constants::STORES_FOLLOWS)
				->where([
					['user_id', $user_id],
					['store_id', $store_id],
				])
				->first();
	}
}