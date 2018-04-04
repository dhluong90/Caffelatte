<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\FoodLikeCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Helpers\ResponseHelper;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

/**
 * Class FoodController
 * @package App\Http\Controllers\Api
 */
class FoodController extends Controller
{
    /**
     * users like food
     * @param $food_id and $user_id
     * @return
     */
    public function like_food($food_id) {
        $result = FoodModel::add_food_like($food_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['yêu thích món ăn không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['like_count' => $result]);
    }

    /**
     * users dislike food
     * @param $food_id and $user_id
     * @return
     */
    public function dislike_food($food_id) {
        $result = FoodModel::remove_food_like($food_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['hủy yêu thích món ăn không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['like_count' => $result]);
    }

    /**
     * users comment food
     * @param food_id, content
     * @return
     */
    public function comment_food(Request $request) {
        if (isset($_POST['content']) && isset($_POST['item_id']) && isset($_POST['rate'])) {
            $content = $_POST['content'];
            $food_id = $_POST['item_id'];
            $rate = $_POST['rate'];
            $result = FoodModel::comment_food($food_id, $content, $rate);

            if ($result === FALSE) {
                $error_type = ResponseHelper::SERVER_ERROR;
                $error_message = ['đăng cảm nhận về món ăn không thành công'];
                return ResponseHelper::error($error_type, $error_message);
            }
            return ResponseHelper::success([
                        'comment_count' => $result['comment'], 
                        'rate' => $result['rate']
                    ]);
        }
        else {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['đăng cảm nhận về món ăn không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
    }
}