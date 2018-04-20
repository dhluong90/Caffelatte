<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\UserQModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Firebase\JWT\JWT;


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

    public function profile(Request $request, $id) {
        $user = UserQModel::get_user_by_id($id);

        if (!$user) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user id not found',
                404
            );
        }

        return ApiHelper::success($user);
    }

    public function update(Request $request) {
        $user_id = $request->input('user_id');
        $data = [];
        if ($request->input('gender')) {
            $data['gender'] = $request->input('gender');
        }

        if ($request->input('chat_id')) {
            $data['chat_id'] = $request->input('chat_id');
        }

        if ($request->input('country')) {
            $data['country'] = $request->input('country');
        }

        if ($request->input('city')) {
            $data['city'] = $request->input('city');
        }

        if ($request->input('language')) {
            $data['language'] = $request->input('language');
        }

        if ($request->input('education')) {
            $data['education'] = $request->input('education');
        }

        if ($request->input('occupation')) {
            $data['occupation'] = $request->input('occupation');
        }

        if ($request->input('sumary')) {
            $data['sumary'] = $request->input('sumary');
        }

        if ($request->input('information')) {
            $data['information'] = $request->input('information');
        }

        if ($request->input('religion')) {
            $data['religion'] = $request->input('religion');
        }

        if ($request->input('fcm_token')) {
            $data['fcm_token'] = $request->input('fcm_token');
        }

        if ($request->input('height')) {
            $data['height'] = intval($request->input('height'));
            if ($data['height'] < 0) {
                return ApiHelper::error(
                    config('constant.error_type.bad_request'),
                    config('constant.error_code.auth.param_wrong'),
                    'param height wrong',
                    400
                );
            } 
        }

        if (empty($data)) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                'param wrong',
                400
            );
        }

        try {
            $user = UserCModel::update_user($user_id, $data);
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'error: ' . $e->getMessage(),
                500
            );
        }

        return ApiHelper::success(['message' => 'success']);
    }

    public function suggest(Request $request) {
        $suggests = [];

        $user_id = $request->input('user_id');
        $user = UserQModel::get_user_by_id($user_id);
        $friends = $user->_friend ? json_decode($user->_friend) : [];
        $suggested = $user->_suggested ? json_decode($user->_suggested) : [];
        $cancelled = $user->_passed ? json_decode($user->_passed) : [];

        if (!empty($user->suggest_at) && $user->suggest_at == date('Y-m-d', time())) {
            // get user in field suggested
        } else {
            // logic suggest
            while (count($friends) > 0 && count($suggests) < 3) {
                // get random 1 friend of friends
                $index = array_rand($friends);
                $person_facebook_id = $friends[$index];
                unset($friends[$index]); // remove this friend

                // get list friend of this person
                $person = UserQModel::get_user_by_facebook_id($person_facebook_id);
                if ($person) {
                    $person_friends = $person->_friend ? json_decode($person->_friend) : [];

                    $suggests_id = [];
                    foreach ($suggests as $item) {
                        array_push($suggests_id, $item->id);
                    }

                    $result = DB::table('users')
                        ->select('*')
                        ->where('id', '!=', $user_id)
                        ->whereIn('facebook_id', $person_friends)
                        ->whereNotIn('id', $suggests_id)
                        ->limit(3)
                        ->get()
                        ->toArray();

                    foreach ($result as $item) {
                        if (count($suggests) < 3) {
                            array_push($suggests, $item);
                        }
                    }
                }
            }
        }

        return ApiHelper::success($suggests);
    }
}