<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Business\UserModel;
use App\Http\Helpers\ResponseHelper;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

/**
 * Class FoodController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * user follow user
     * @param $user_id
     * @return
     */
    public function follow_user($user_id) {
        if ($user_id == Auth::id()) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['không thể theo dõi chính mình'];
            return ResponseHelper::error($error_type, $error_message);
        }
        $result = UserModel::add_user_follow($user_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['theo dõi người dùng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['follow_count' => $result]);
    }

    /**
     * user unfollow user
     * @param $user_id
     * @return
     */
    public function unfollow_user($user_id) {
        if ($user_id == Auth::id()) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['không thể hủy theo dõi chính mình'];
            return ResponseHelper::error($error_type, $error_message);
        }
        $result = UserModel::remove_user_follow($user_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['hủy theo dõi người dùng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['follow_count' => $result]);
    }
}