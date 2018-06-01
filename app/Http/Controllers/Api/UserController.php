<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Helpers\NotificationHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\SuggestCModel;
use App\Http\Models\Dal\SuggestQModel;
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

        if ($request->input('birthday')) {
            $data['birthday'] = $request->input('birthday');
        }

        if ($request->input('school')) {
            $data['school'] = $request->input('school');
        }

        if ($request->input('degree')) {
            $data['degree'] = $request->input('degree');
        }

        if ($request->input('employer')) {
            $data['employer'] = $request->input('employer');
        }

        if ($request->input('ethnicity')) {
            $data['ethnicity'] = $request->input('ethnicity');
        }

        if ($request->input('name')) {
            $data['name'] = $request->input('name');
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

    public function like(Request $request) {
        $user_id = $request->input('user_id');
        $matching_id = $request->input('matching_id');

        // check user matching
        $user_matching = UserQModel::get_user_by_id($matching_id);
        if (!$user_matching) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching id not found',
                404
            );
        }

        // get current
        $user_current = UserQModel::get_user_by_id($user_id);

        // case 1: user matching is suggested by current user
        $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));

        // case 2: check matching_id is liked current user
        $liked_item = SuggestQModel::get_record_by_status($matching_id, $user_id, config('constant.suggest.status.liked'));

        if (!$suggested_item && !$liked_item) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching can not like',
                404
            );
        }

        if ($liked_item) {
            SuggestCModel::update_suggest($liked_item->id, [
                'status' => config('constant.suggest.status.approved'),
                'updated_at' => date('Y-m-d', time())
            ]);

            // delete suggest if excess record
            if ($suggested_item) {
                SuggestCModel::delete_suggest($suggested_item->id);
            }

            // todo realtime
            if ($user_current->fcm_token) {
                $result = NotificationHelper::send($user_matching->fcm_token, [
                        'title' => 'Cafelatte',
                        'body' => $user_current->name . ' like you'
                    ], [
                        'chat_id' => $user_current->chat_id,
                        'matching_chat_id' => $user_matching->chat_id,
                        'type' => 'like'
                    ]);
            }

            return ApiHelper::success(['message' => 'success', 'chat_id' => $user_matching->chat_id]);
        } else {
            SuggestCModel::update_suggest($suggested_item->id, [
                'status' => config('constant.suggest.status.liked'),
                'updated_at' => date('Y-m-d', time())
            ]);

            return ApiHelper::success(['message' => 'success', 'chat_id' => null]);
        }
    }

    public function pass(Request $request) {
        $user_id = $request->input('user_id');
        $matching_id = $request->input('matching_id');

        // check user matching
        $user_matching = UserQModel::get_user_by_id($matching_id);
        if (!$user_matching) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching id not found',
                404
            );
        }

        // case 1: user matching is suggested by current user
        $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));

        // case 2: matching_id is liked current user
        $liked_item = SuggestQModel::get_record_by_status($matching_id, $user_id, config('constant.suggest.status.liked'));

        if (!$suggested_item && !$liked_item) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching can not pass',
                404
            );
        }

        if ($suggested_item) {
            SuggestCModel::update_suggest($suggested_item->id, [
                'status' => config('constant.suggest.status.passed'),
                'updated_at' => date('Y-m-d', time())
            ]);

            return ApiHelper::success(['message' => 'success']);
        }

        if ($liked_item) {
            SuggestCModel::update_suggest($liked_item->id, [
                'status' => config('constant.suggest.status.passed'),
                'updated_at' => date('Y-m-d', time())
            ]);

            return ApiHelper::success(['message' => 'success']);
        }

        return ApiHelper::error();
    }

    public function suggest(Request $request) {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }

        $suggests = [];

        $user_id = $request->input('user_id');
        $user = UserQModel::get_user_by_id($user_id);

        if (!empty($user->suggest_at) && $user->suggest_at == date('Y-m-d', $current_time)) {
            // get user in field suggested
            $result = SuggestQModel::get_current_suggest($user_id, json_decode($user->_suggested), $user->suggest_at, config('constant.suggest.limit'));

            return ApiHelper::success($result);
        } else {
            // get friend from table user
            $friends = $user->_friend ? json_decode($user->_friend) : [];
            $friends_temp = $friends;

            // remove old suggest (not like, pass)
            SuggestCModel::reset_suggest($user_id);

            // get user like me to suggest
            $users_like_me = SuggestQModel::get_users_like_me($user_id, config('constant.suggest.limit'));
            foreach ($users_like_me as $item) {
                array_push($suggests, $item);
            }

            // get new matching
            while (count($friends_temp) > 0 && count($suggests) < config('constant.suggest.limit')) {
                // get random 1 friend of friends
                $index = array_rand($friends_temp);
                $person_facebook_id = $friends_temp[$index];
                unset($friends_temp[$index]); // remove this friend

                // get list friend of this person
                $person = UserQModel::get_user_by_facebook_id($person_facebook_id);
                if ($person) {
                    $person_friends = $person->_friend ? json_decode($person->_friend) : [];

                    $result = SuggestQModel::get_new_suggest($user, $person_friends, $suggests);

                    foreach ($result as $item) {
                        if (count($suggests) < config('constant.suggest.limit')) {
                            array_push($suggests, $item);
                        }
                    }
                }
            }

            if (!empty($suggests)) {
                $data = [];
                $matching_ids = [];
                foreach ($suggests as $item) {
                    array_push($matching_ids, $item->id);

                    // if new suggest
                    if (empty($item->status)) {
                        array_push($data, [
                            'user_id' => $user_id,
                            'matching_id' => $item->id,
                            'status' => config('constant.suggest.status.suggested'),
                            'created_at' => date('Y-m-d', $current_time)
                        ]);
                    }
                }

                // save list suggest table suggest (get list suggest not like me)
                if (!empty($data)) {
                    SuggestCModel::create_suggest($data);
                }

                // update cache field _suggested table user
                UserCModel::update_user($user_id, [
                    '_suggested' => json_encode($matching_ids),
                    'suggest_at' => date('Y-m-d', $current_time)
                ]);
            }
        }

        return ApiHelper::success($suggests);
    }

    public function manual_friend(Request $request, $id) {
        $user_id = $request->input('user_id');
        $user = UserQModel::get_user_by_id($user_id);
        $my_friend = UserQModel::get_user_by_id($id);

        $manual_friends = array_intersect(json_decode($user->_friend), json_decode($my_friend->_friend));
        $result = UserQModel::get_users_by_facebooks($manual_friends);

        return ApiHelper::success($result);
    }

    public function push_user(Request $request, $matching_id) {
        $user_id = $request->input('user_id');
        $user = UserQModel::get_user_by_id($user_id);
        $user_matching = UserQModel::get_user_by_id($matching_id);

        $title = $request->input('title');
        $body = $request->input('body');
        $data = $request->input('data');
        $result = NotificationHelper::send($user_matching->fcm_token, [
                'title' => $title,
                'body' => $body,
                'sound' => 'default'
            ], $data);
        return ApiHelper::success(['message' => 'success']);
    }
}