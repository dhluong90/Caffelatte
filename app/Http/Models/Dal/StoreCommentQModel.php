<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class StoreCommentQModel extends Model {
	/**
	 * get store_comment by store_id and user_id
	 * @param store_id, user_id
	 * @return object collection
	 */
	public static function get_store_comment($store_id, $user_id) {
		return DB::table(Constants::STORES_COMMENTS)
				->where([
					['store_id', $store_id],
					['user_id', $user_id],
				])
				->first();
	}

	/**
	 * get store comment by store id
	 * @param store_id
	 * @return array
	 */
	public static function get_store_comments_by_store_id($store_id) {
		return DB::table(Constants::STORES_COMMENTS . ' as sc')
				->join(Constants::USERS . ' as u', 'u.id', '=', 'sc.user_id')
				->where('store_id', $store_id)
				->select('sc.*', 'u.id as user_id', 'u.name as user_name', 'u.image as user_image', 'u._follow as user_follow')
				->take(6)
				->orderBy('sc.id', 'DESC')
				->get()
				->toArray();
	}
}