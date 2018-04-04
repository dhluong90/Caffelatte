<?php

namespace App\Http\Models\Business;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\FoodCModel;
use App\Http\Models\Dal\FoodTagQModel;
use App\Http\Models\Dal\FoodTagCModel;
use App\Http\Models\Dal\FoodLikeCModel;
use App\Http\Models\Dal\FoodLikeQModel;
use App\Http\Models\Dal\FoodCategoryCModel;
use App\Http\Models\Dal\FoodCommentCModel;
use App\Http\Helpers\ResponseHelper;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

class FoodModel extends Model
{
    /**
     * create food
     * @param $data array
     * @return boolean
     */
    public static function create_food($data) {
        $food_id = FoodCModel::insert_food($data['food']);

        //Create data food tag to store in foods_tags DB
        $data_food_tag = [];
        foreach ($data['tag'] as $tag_id) {
            $tag = [
                'food_id' => $food_id,
                'tag_id' => $tag_id
            ];
            array_push($data_food_tag, $tag);
        }
        FoodTagCModel::insert_food_tag($data_food_tag);

        //Create data food category to store in foods_categories DB
        $data_food_category = [
            'food_id' => $food_id,
            'category_id' => $data['category']
        ];
	    FoodCategoryCModel::insert_food_category($data_food_category);

        return $food_id;
    }

    /**
     * update food
     * @param $food_id int, $data array
     * @return boolean
     */
    public static function update_food($food_id, $data) {
        // Get food
        $food = FoodQModel::get_food_by_id($food_id);
        if (FoodCModel::update_food($food_id, $data['food'])) {
            //Delete old image file
            if (!empty($data['food']['images'])) {
                ImageHelper::delete_image($food->images, Constants::MANAGE_IMAGE['food']);
            }

            $data_food_category = [
                'food_id' => $food_id,
                'category_id' => $data['category']
            ];
            FoodCategoryCModel::update_food_category($food_id, $data_food_category);

            // Convert data type of values to string
            $existed_tags = array_map('strval', FoodTagQModel::get_tag_ids_by_food_id($food_id));
            // Sort ascending to compare 2 arrays
            sort($existed_tags);
            sort($data['tags']);
            // Check if tags change
            if ($data['tags'] != $existed_tags) {
                // Delete old food tags
                if (FoodTagCModel::delete_food_tag_by_food_id($food_id)) {
                    // Insert new food tags
                    foreach ($data['tags'] as $tag_id) {
                        $tag = [
                            'food_id' => $food_id,
                            'tag_id' => $tag_id
                        ];
                        FoodTagCModel::insert_food_tag($tag);
                    }
                    return TRUE;
                }
                return FALSE;
            }
            return TRUE;
        } else {// update with no changes in foods table (No data effected when update foods table)
            $data_food_category = [
                'food_id' => $food_id,
                'category_id' => $data['category']
            ];
            FoodCategoryCModel::update_food_category($food_id, $data_food_category);

            // Convert data type of values to string
            $existed_tags = array_map('strval', FoodTagQModel::get_tag_ids_by_food_id($food_id));
            // Sort ascending to compare 2 arrays
            sort($existed_tags);
            sort($data['tags']);
            // Check if tags change
            if ($data['tags'] != $existed_tags) {
                // Delete old food tags
                if (FoodTagCModel::delete_food_tag_by_food_id($food_id)) {
                    // Insert new food tags
                    foreach ($data['tags'] as $tag_id) {
                        $tag = [
                            'food_id' => $food_id,
                            'tag_id' => $tag_id
                        ];
                        FoodTagCModel::insert_food_tag($tag);
                    }
                    return TRUE;
                }
                return FALSE;
            }
            return TRUE;
        }
    }

    /**
     * add food like
     * @param food_id
     * @return boolean
     */
    public static function add_food_like($food_id) {
        //check food
        $food = FoodQModel::get_food_by_id($food_id);
        if (!$food) {
            return FALSE;
        }

        //add new record food_like
        $data['food_like'] = [
            'food_id' => $food_id,
            'user_id' => Auth::id(),
            'created_at' => time()
        ];
        FoodLikeCModel::insert_food_like($data['food_like']);

        //update amount like in food table
        $like = FoodQModel::get_food_by_id($food_id)->_like;
        FoodCModel::update_food($food_id, [
            '_like' => $like + 1,
        ]);

        return FoodQModel::get_food_by_id($food_id)->_like;
    }

    /**
     * remove food like
     * @param food_id
     * @return boolean
     */
    public static function remove_food_like($food_id) {
        //check food
        $food = FoodQModel::get_food_by_id($food_id);
        if (!$food) {
            return FALSE;
        }

        //remove record food_like
        $data_food = FoodLikeQModel::get_food_like($food_id, Auth::id());
        FoodLikeCModel::delete_food_like($data_food->id);

        //update amount like in food table
        $like = FoodQModel::get_food_by_id($food_id)->_like;
        FoodCModel::update_food($food_id, [
            '_like' => ($like > 0) ? $like - 1 : 0,
        ]);
        return FoodQModel::get_food_by_id($food_id)->_like;
    }

    /**
     * get array food id by user id
     * @param user_id
     * @return boolean
     */
    public static function get_foods_like_id_by_user_id($user_id) {
        $foods_like = FoodQModel::get_like_foods_by_user_id($user_id);
        $array = [];
        foreach ($foods_like as $food) {
            array_push($array, $food->id);
        }
        return $array;
    }

    /** 
     * add new comment to food
     * @param food_id, content
     * @return boolean
     */
    public static function comment_food($food_id, $content, $rate) {
        //check food
        $food = FoodQModel::get_food_by_id($food_id);
        if (!$food) {
            return FALSE;
        }

        //add new comment food
        $data = [
            'food_id' => $food_id,
            'user_id' => Auth::id(),
            'content' => $content,
            'rate'    => $rate,
            'created_at' => time(),
        ];
        FoodCommentCModel::insert_food_comment($data);

        //update amount comment food
        $comment = FoodQModel::get_food_by_id($food_id)->_comment;
        FoodCModel::update_food($food_id,[
            '_comment' => $comment + 1,
        ]);

        //update rate store
        $comment = $comment;
        $rate_old = FoodQModel::get_food_by_id($food_id)->_rate;
        FoodCModel::update_food($food_id, [
            '_rate' => ($rate_old * $comment + $rate) / ($comment + 1),
        ]);

        $comment = FoodQModel::get_food_by_id($food_id)->_comment;
        $rate = FoodQModel::get_food_by_id($food_id)->_rate;
        return ['comment' => $comment, 'rate' => $rate];
    }
}