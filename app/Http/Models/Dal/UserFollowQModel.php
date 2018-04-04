<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Constants;
use Illuminate\Support\Facades\DB;

class UserFollowQModel extends Model {
	/**
	 * get user follow by user_id and follower_id
	 * @param user_id, follower_id (user is followed) 
	 * @return object collection
	 */
	public static function get_user_follow($user_id, $follower_id) {
		return DB::table(Constants::USERS_FOLLOWS)
				->where([
					['user_id', $user_id],
					['follower_id', $follower_id],
				])
				->first();
	}
}