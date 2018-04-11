<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\UserQModel;
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
        $cancelled = $user->_cancelled ? json_decode($user->_cancelled) : [];

        // get random 1 friend of friends
        $index = array_rand($friends);
        $person_facebook_id = $friends[$index];
        unset($friends[$index]); // remove this friend

        // get list friend of this person
        $person = UserQModel::get_user_by_facebook_id($person_facebook_id);
        if ($person) {
            $person_friends = $person->_friend ? json_decode($person->_friend) : [];

            $result = DB::table('users')
                ->select('id', 'name', 'image', 'phone', 'gender', 'chat_id', 'country', 'address', 'city')
                ->whereIn('facebook_id', $person_friends)
                ->whereNotIn('id', array_merge($suggested, $cancelled))
                ->get();
        }

        return ApiHelper::success($suggests);
    }

    function get_mutual_friend($user, $person) {
        // get list friend of this person
        $person = UserQModel::get_user_by_facebook_id($person_facebook_id);
        $person_friends = json_decode($person->_friend);

        $suggests = DB::table('users')
            ->select('id', 'name', 'image', 'phone', 'gender', 'chat_id', 'country', 'address', 'city')
            ->whereIn('facebook_id', $person_friends)
            ->whereNotIn('id', array_merge($suggested, $cancelled))
            ->get();
        return $suggests;
    }
}