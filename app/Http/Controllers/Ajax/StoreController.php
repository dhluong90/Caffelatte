<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\StoreLikeCModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Business\StoreModel;
use App\Http\Helpers\ResponseHelper;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

/**
 * Class StoreController
 * @package App\Http\Controllers\Api
 */
class StoreController extends Controller
{
    /**
     * users like store
     * @param $store_id
     * @return
     */
    public function like_store($store_id) {
        $result = StoreModel::add_store_like($store_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['yêu thích cửa hàng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['like_count' => $result]);
    }

    /**
     * users dislike store
     * @param $store_id
     * @return
     */
    public function dislike_store($store_id) {
        $result = StoreModel::remove_store_like($store_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['hủy yêu thích cửa hàng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['like_count' => $result]);
    }

    /**
     * user follow store
     * @param $store_id
     * @return
     */
    public function follow_store($store_id) {
        $result = StoreModel::add_store_follow($store_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['theo dõi cửa hàng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['follow_count' => $result]);
    }

    /**
     * user unfollow store
     * @param $store_id
     * @return
     */
    public function unfollow_store($store_id) {
        $result = StoreModel::remove_store_follow($store_id);
        if ($result === FALSE) {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['hủy theo dõi cửa hàng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
        return ResponseHelper::success(['follow_count' => $result]);
    }

    /**
     * users comment store
     * @param store_id, content
     * @return
     */
    public function comment_store(Request $request) {
        if (isset($_POST['content']) && isset($_POST['item_id']) && isset($_POST['rate'])) {
            $content = $_POST['content'];
            $store_id = $_POST['item_id'];
            $rate = $_POST['rate'];
            $result = StoreModel::comment_store($store_id, $content, $rate);
            
            if ($result === FALSE) {
                $error_type = ResponseHelper::SERVER_ERROR;
                $error_message = ['đăng cảm nhận về cửa hàng không thành công'];
                return ResponseHelper::error($error_type, $error_message);
            }
            return ResponseHelper::success([
                        'comment_count' => $result['comment'], 
                        'rate' => $result['rate']
                    ]);
        }
        else {
            $error_type = ResponseHelper::SERVER_ERROR;
            $error_message = ['đăng cảm nhận về cửa hàng không thành công'];
            return ResponseHelper::error($error_type, $error_message);
        }
    }
}