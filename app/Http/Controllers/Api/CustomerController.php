<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Helpers\NotificationHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\CustomerCModel;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Models\Dal\SuggestCModel;
use App\Http\Models\Dal\SuggestQModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use \Firebase\JWT\JWT;
use Yish\Imgur\Facades\Upload as Imgur;


/**
 * Class CustomerController
 * @package App\Http\Controllers\Api
 */
class CustomerController extends Controller
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
        $user = CustomerQModel::get_user_by_id($id);

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
        if ($request->input('gender') || $request->input('gender') === 0) {
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
            $user = CustomerCModel::update_user($user_id, $data);
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
        $user_matching = CustomerQModel::get_user_by_id($matching_id);
        if (!$user_matching) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching id not found',
                404
            );
        }

        // get current
        $user_current = CustomerQModel::get_user_by_id($user_id);

        // case 1: user matching liked current user
        $liked_item = SuggestQModel::get_record_by_status($matching_id, $user_id, config('constant.suggest.status.liked'));

        if ($liked_item) {
            SuggestCModel::update_suggest($liked_item->id, [
                'status' => config('constant.suggest.status.approved'),
                'updated_at' => date('Y-m-d', time())
            ]);

            // delete suggest if exist record
            $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));
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
        }

        // case 2: user matching have suggested for current user
        $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));

        if ($suggested_item) {
            SuggestCModel::update_suggest($suggested_item->id, [
                'status' => config('constant.suggest.status.liked'),
                'updated_at' => date('Y-m-d', time())
            ]);

            return ApiHelper::success(['message' => 'success', 'chat_id' => null]);
        }

        // case 3: user matching is discover by current user
        $discover_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.discover'));

        if ($discover_item) {
            if ($user_current->point < 1) {
                return ApiHelper::error(
                    config('constant.error_type.bad_request'),
                    config('constant.error_code.customer.point_not_enough'),
                    'user not enough point',
                    400
                );
            }

            SuggestCModel::update_suggest($discover_item->id, [
                'status' => config('constant.suggest.status.liked'),
                'updated_at' => date('Y-m-d', time())
            ]);

            // decrease point user
            CustomerCModel::update_user($user_id, [
                'point' => $user_current->point - 1
            ]);

            return ApiHelper::success(['message' => 'success', 'chat_id' => null]);
        }

        return ApiHelper::error(
            config('constant.error_type.not_found'), 404,
            'user matching can not like',
            404
        );
    }

    public function pass(Request $request) {
        $user_id = $request->input('user_id');
        $matching_id = $request->input('matching_id');

        // check user matching
        $user_matching = CustomerQModel::get_user_by_id($matching_id);
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

    public function unmatch(Request $request) {
        $user_id = $request->input('user_id');
        $matching_id = $request->input('matching_id');

        // check user matching
        $user_matching = CustomerQModel::get_user_by_id($matching_id);
        if (!$user_matching) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user unmatch id not found',
                404
            );
        }

        $item = SuggestQModel::get_unmatch_by_user_id($user_id, $matching_id);

        if (!$item) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching can not unmatch',
                404
            );
        }

        SuggestCModel::update_suggest($item->id, [
            'status' => config('constant.suggest.status.unmatch'),
            'updated_at' => date('Y-m-d', time())
        ]);

        return ApiHelper::success(['message' => 'success']);
    }

    public function list_unmatch(Request $request) {
        $user_id = $request->input('user_id');

        $list = SuggestQModel::get_list_unmatch_by_user_id($user_id);

        if (!$list) {
            return ApiHelper::success([]);
        }

        return ApiHelper::success($list);
    }

    public function suggest(Request $request) {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }

        $suggests = [];

        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);

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
                $person = CustomerQModel::get_user_by_facebook_id($person_facebook_id);
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

                // update cache field _suggested table customer
                CustomerCModel::update_user($user_id, [
                    '_suggested' => json_encode($matching_ids),
                    'suggest_at' => date('Y-m-d', $current_time)
                ]);
            }
        }

        return ApiHelper::success($suggests);
    }

    public function discover(Request $request) {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }

        $suggests = [];

        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);

        if (!empty($user->discover_at) && $user->discover_at == date('Y-m-d', $current_time)) {
            // get user in field suggested
            $result = SuggestQModel::get_current_discover($user_id, $user->discover_at);

            return ApiHelper::success($result);
        } else {
            // remove old discover yesterday
            SuggestCModel::reset_discover($user_id);

            // get new discover
            $result = SuggestQModel::get_new_discover($user);

            if (!empty($result)) {
                $data = [];
                foreach ($result as $item) {
                    array_push($data, [
                        'user_id' => $user_id,
                        'matching_id' => $item->id,
                        'status' => config('constant.suggest.status.discover'),
                        'created_at' => date('Y-m-d', $current_time)
                    ]);
                }

                // save list discover table suggest
                if (!empty($data)) {
                    SuggestCModel::create_suggest($data);
                }

                // update discover_at table customer
                CustomerCModel::update_user($user_id, [
                    'discover_at' => date('Y-m-d', $current_time)
                ]);

                return ApiHelper::success($result);
            }
        }

        return ApiHelper::success($suggests);
    }

    public function manual_friend(Request $request, $id) {
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $my_friend = CustomerQModel::get_user_by_id($id);

        $manual_friends = array_intersect(json_decode($user->_friend), json_decode($my_friend->_friend));
        $result = CustomerQModel::get_users_by_facebooks($manual_friends);

        return ApiHelper::success($result);
    }

    public function push_user(Request $request, $matching_id) {
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $user_matching = CustomerQModel::get_user_by_id($matching_id);

        $title = $request->input('title');
        $body = $request->input('body');
        $data = $request->input('data');
        $result = NotificationHelper::send($user_matching->fcm_token, [
                'title' => $title,
                'body' => $body
            ], $data);
        return ApiHelper::success(['message' => 'success']);
    }

    public function add_point(Request $request) {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);

        if ($user->point_at != date('Y-m-d', $current_time)) {
            // new date, reset old_point
            CustomerCModel::update_user($user_id, [
                'point' => $user->point + 1,
                'old_point' => 1,
                'point_at' => date('Y-m-d', $current_time)
            ]);

            return ApiHelper::success(['message' => 'success add point new date']);
        } else {
            if ($user->old_point < 3) {
                CustomerCModel::update_user($user_id, [
                    'point' => $user->point + 1,
                    'old_point' => $user->old_point + 1
                ]);

                return ApiHelper::success(['message' => 'success add point']);
            } else {
                return ApiHelper::error(
                    config('constant.error_type.bad_request'),
                    config('constant.error_code.customer.point_limit'),
                    'point limit',
                    400
                );
            }
        }
    }

    public function upload_avatar(Request $request) {
        $rules = array(
            'image' => 'required | mimes:jpeg,jpg,png',
            'location' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.customer.image_error_format'),
                'validate image, location error',
                400
            );
        }
        $file = $request->file('image');
        $location = $request->input('location');

        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $images = json_decode($user->image);

        // clear image user
        for ($i = 0; $i < config('constant.customer.count_image'); $i++) {
            if (!isset($images[$i])) {
                $images[$i] = '';
            }
        }

        try {
            $image = Imgur::upload($file);
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.common.server_error'),
                'Upload failed: ' . $e->getMessage(),
                400
            );
        }

        $images[$location] = $image->link();

        CustomerCModel::update_user($user_id, [
            'image' => json_encode($images),
        ]);

        return ApiHelper::success(['message' => 'upload image success']);
    }

    public function delete_avatar(Request $request) {
        $rules = array(
            'location' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'), 400,
                'location missing',
                400
            );
        }
        $location = $request->input('location');
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $images = json_decode($user->image);

        $images[$location] = '';

        CustomerCModel::update_user($user_id, [
            'image' => json_encode($images),
        ]);

        return ApiHelper::success(['message' => 'upload image success']);
    }
}