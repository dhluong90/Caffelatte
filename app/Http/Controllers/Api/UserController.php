<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Business\UserModel;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index() {

    }

    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;
        $device = $request->device;
        $type_device = $request->type_device;

        // validate
        if (!$username || !$password) {
            return ApiHelper::error(
                ApiHelper::USERNAME_PASSWORD_REQUIRE,
                ['Tài khoản và mật khẩu không được để trống'],
                400
            );
        }

        // todo validate type device

        // check user login
        $user = UserModel::login($username, $password);
        if (!$user) {
            return ApiHelper::error(
                ApiHelper::USERNAME_PASSWORD_INCORRECT,
                ['Tài khoản hoặc mật khẩu không đúng'],
                403
            );
        }

        // update or create record device token
        $token = UserModel::get_token($user, $device, $type_device);

        if (!$token) { 
            return ApiHelper::error(
                ApiHelper::SERVER_ERROR,
                ['Lỗi server'],
                500
            );
        }

        $data = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'image' => $user->image,
            'token' => $token,
        ];

        return ApiHelper::success((object)$data, 200);
    }
}