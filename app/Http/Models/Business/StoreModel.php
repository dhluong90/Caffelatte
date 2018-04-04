<?php

namespace App\Http\Models\Business;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\StoreLikeCModel;
use App\Http\Models\Dal\StoreLikeQModel;
use App\Http\Models\Dal\StoreFollowQModel;
use App\Http\Models\Dal\StoreFollowCModel;
use App\Http\Models\Dal\StoreCommentCModel;


class StoreModel extends Model
{
	/**
	 * add store like
	 * @param store_id
	 * @return boolean or numeric
	 */
	public static function add_store_like($store_id) {
        //check store
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return FALSE;
        }

        //add new record store_like
        $data['store_like'] = [
            'store_id' => $store_id,
            'user_id' => Auth::id(),
            'created_at' => time()
        ];
        StoreLikeCModel::insert_store_like($data['store_like']);

        //update amount like in store table
        $like = StoreQModel::get_store_by_id($store_id)->_like;
        StoreCModel::update_store($store_id, [
            '_like' => $like + 1,
        ]);

        return StoreQModel::get_store_by_id($store_id)->_like;
    }

    /**
     * remove store like
     * @param store_id
     * @return boolean
     */
    public static function remove_store_like($store_id) {
        //check store
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return FALSE;
        }

        //remove record store_like
        $data_store = StoreLikeQModel::get_store_like($store_id, Auth::id());
        StoreLikeCModel::delete_store_like($data_store->id);

        //update amount like in store table
        $like = StoreQModel::get_store_by_id($store_id)->_like;
        StoreCModel::update_store($store_id, [
            '_like' => ($like > 0) ? $like - 1 : 0,
        ]);

        return StoreQModel::get_store_by_id($store_id)->_like;
    }

    /**
     * add store follow
     * @param $store_id
     * @return boolean or numeric
     */
    public static function add_store_follow($store_id) {
        //check store
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return  FALSE;
        }

        //add new record
        $data = [
            'store_id' => $store_id,
            'user_id' => Auth::id(),
            'created_at' => time(),
        ];
        StoreFollowCModel::insert_store_follow($data);

        //update amount follow in store table
        $follow = StoreQModel::get_store_by_id($store_id)->_follow;
        StoreCModel::update_store($store_id, [
            '_follow' => $follow + 1,
        ]);

        return StoreQModel::get_store_by_id($store_id)->_follow;
    }

    /**
     * remove store follow
     * @param store_id
     * @return boolean
     */
    public static function remove_store_follow($store_id) {
        //check store
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return FALSE;
        }

        //remove record store_follow
        $data = StoreFollowQModel::get_store_follow($store_id, Auth::id());
        StoreFollowCModel::delete_store_follow($data->id);

        //update amount like in store table
        $follow = StoreQModel::get_store_by_id($store_id)->_follow;
        StoreCModel::update_store($store_id, [
            '_follow' => ($follow > 0) ? $follow - 1 : 0,
        ]);

        return StoreQModel::get_store_by_id($store_id)->_follow;
    }

    /**
     * get array store id by user id
     * @param user_id
     * @return array store id
     */
    public static function get_stores_like_id_by_user_id($user_id) {
        $stores_like = StoreQModel::get_like_stores_by_user_id($user_id);
        $array = [];
        foreach ($stores_like as $food) {
            array_push($array, $food->id);
        }
        return $array;
    }

    /**
     * get array store id by user id
     * @param user_id
     * @return array store id
     */
    public static function get_stores_follow_id_by_user_id($user_id) {
        $stores_follow = StoreQModel::get_follow_stores_by_user_id($user_id);
        $array = [];
        foreach ($stores_follow as $food) {
            array_push($array, $food->id);
        }
        return $array;
    }

    /** 
     * add new comment to store
     * @param store_id, content
     * @return boolean
     */
    public static function comment_store($store_id, $content, $rate) {
        //check store
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return FALSE;
        }

        //add new comment food
        $data = [
            'store_id' => $store_id,
            'user_id' => Auth::id(),
            'content' => $content,
            'rate' => $rate,
            'created_at' => time(),
        ];
        StoreCommentCModel::insert_store_comment($data);

        //update amount comment store
        $comment = StoreQModel::get_store_by_id($store_id)->_comment;
        StoreCModel::update_store($store_id,[
            '_comment' => $comment + 1,
        ]);

        //update rate store
        $comment = $comment + 1;
        $rate_old = StoreQModel::get_store_by_id($store_id)->_rate;
        StoreCModel::update_store($store_id, [
            '_rate' => ($rate_old * ($comment - 1) + $rate)/$comment,
        ]);

        $comment = StoreQModel::get_store_by_id($store_id)->_comment;
        $rate = StoreQModel::get_store_by_id($store_id)->_rate;
        return ['comment' => $comment, 'rate' => $rate];
    }
}
