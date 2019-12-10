<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\FirebaseDatabaseHelper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Helpers\NotificationHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\CustomerCModel;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Models\Dal\SuggestCModel;
use App\Http\Models\Dal\SuggestQModel;
use Carbon\Carbon;
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
use Iivannov\Branchio\Support\UrlType;
use Iivannov\Branchio\Integration\Laravel\Facade\Branchio;
use Iivannov\Branchio\Link;


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

    public $ruleUpdateUser = [
        'phone' => 'sometimes|required|phone:VN,SG,TH,LA,MM,MY',
        'email' => 'sometimes|required|email'
    ];

    public function index()
    {

    }

    public function profile(Request $request, $id)
    {
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

    /**
     * @param Request $request
     * @param $id
     * @return \App\Http\Helpers\json
     */
    public function profile_by_chat_id(Request $request, $textId)
    {
        $listId = explode(",", $textId);
        $user = CustomerQModel::get_users_by_chat_id($listId);
        if (!$user) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'chat id not found',
                404
            );
        }

        $user = ApiHelper::clear_data_member($user);

        return ApiHelper::success($user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \App\Http\Helpers\json
     */
    public function profile_by_ids(Request $request, $ids)
    {
        $listId = explode(",", $ids);
        $user = CustomerQModel::get_users_by_ids($listId);
        if (!$user) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'chat id not found',
                404
            );
        }

        $user = ApiHelper::clear_data_member($user);

        return ApiHelper::success($user);
    }

    public function update(Request $request)
    {
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

        if ($request->input('phone')) {
            $data['phone'] = $request->input('phone');
        }
        if ($request->input('email')) {
            $data['email'] = $request->input('email');
        }
        if ($request->input('_interests') && is_array($request->input('_interests'))) {
            $data['_interests'] = json_encode($request->input('_interests'));
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
        $validation = Validator::make($data, $this->ruleUpdateUser);
        if ($validation->fails()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                $validation->errors()->first(),
                400
            );
        }

        if (!is_numeric($data) && empty($data)) {
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

    public function updateV2(Request $request)
    {
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

        if ($request->input('phone')) {
            $data['phone'] = $request->input('phone');
        }
        if ($request->input('email')) {
            $data['email'] = $request->input('email');
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
        $validation = Validator::make($data, $this->ruleUpdateUser);
        if ($validation->fails()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                $validation->errors()->first(),
                400
            );
        }

        if (!is_numeric($data) && empty($data)) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                'param wrong',
                400
            );
        }
        
        try {
            CustomerCModel::update_user($user_id, $data);
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'error: ' . $e->getMessage(),
                500
            );
        }

        $user = CustomerQModel::get_user_by_id($user_id);
        try {
            if ($user && !$user->share_link && $user->name) {
                $share_link = $this->generate_branch_io_link($user->id, $user->name);
                $detail_link = $this->get_link_data($share_link);
                $data_update['share_link_id'] = $detail_link->data->{'~id'};
                $data_update['share_link'] = $share_link;
                $data_update['share_link_created_at'] = Carbon::now();
                CustomerCModel::update_user($user_id, $data_update);
                $user = CustomerQModel::get_user_by_id($user_id);
            }
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'error: ' . $e->getMessage(),
                500
            );
        }

        return ApiHelper::success($user);
    }

    public function like(Request $request)
    {
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

        $user_current_suggest = json_decode($user_current->_suggested);
        if (count($user_current_suggest) < 5) {
            $top_suggest_id = $user_current_suggest;
        } else {
            $top_suggest_id = [$user_current_suggest[0], $user_current_suggest[1], $user_current_suggest[2], $user_current_suggest[3], $user_current_suggest[4]];
        }

        // case 1: user matching liked current user
        $liked_item = SuggestQModel::get_record_by_status($matching_id, $user_id, config('constant.suggest.status.liked'));

        if ($liked_item) {
            SuggestCModel::update_suggest($liked_item->id, [
                'status' => config('constant.suggest.status.approved'),
                'updated_at' => date('Y-m-d', time())
            ]);

            $value = FirebaseDatabaseHelper::get_firebase_connection()->getReference('Conversations')
                ->getValue();
            $found = false;
            foreach($value as $item) {
                if(count($item) > 0 ) {
                    $fromId = $item[key($item)]['fromID'];
                    $toId = $item[key($item)]['toID'];
                    if (($fromId == $user_current->id && $toId == $user_matching->id) ||
                        ($toId == $user_current->id && $fromId == $user_matching->id)
                    ) {
                        $found = true;
                    }
                }
                break;
            }
            if (!$found) {
                // Check if those users chatted before
                $conversationID = FirebaseDatabaseHelper::get_firebase_connection()->getReference('Users')
                    ->getChild($user_current->id.'/Conversations')
                    ->getChild($user_matching->id.'/location')->getValue();

                // If not, init new conversation between them
                if(empty($conversationID)) {
                    $conversationID = FirebaseDatabaseHelper::get_firebase_connection()->getReference('Conversations')
                        ->push([[
                            'content' => '',
                            'fromID' => $user_current->id,
                            'seen' => false,
                            'timestamp' => time(),
                            'toID' => $user_matching->id,
                            'type' => 'init'
                        ]])->getKey();
                }

                FirebaseDatabaseHelper::get_firebase_connection()->getReference('Users')
                    ->getChild($user_current->id.'/Conversations')->update([
                        $user_matching->id => ['location' => $conversationID, 'isDisabled' => false]]);
                FirebaseDatabaseHelper::get_firebase_connection()->getReference('Users')
                    ->getChild($user_matching->id.'/Conversations')->update([
                        $user_current->id => ['location' => $conversationID, 'isDisabled' => false]]);
            }

            // delete suggest if exist record
            $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));
            if ($suggested_item) {
                SuggestCModel::update_suggest($suggested_item->id,[
                    'status' => 7,
                    'updated_at' => date('Y-m-d', time())
                ]);
            }

            // todo realtime
            if ($user_current->fcm_token) {
                $result = NotificationHelper::send($user_matching->fcm_token, [
                    'title' => 'Cafelatte',
                    'body' => $user_current->name . ' like you'
                ], [
                    'user_id' => $user_current->id,
                    'chat_id' => $user_current->chat_id,
                    'user_matching_id' => $user_matching->id,
                    'matching_chat_id' => $user_matching->chat_id,
                    'type' => 'like'
                ]);
            }

            return ApiHelper::success(['message' => 'success', 'user_id' => $user_matching->id, 'remain_like' => $user_current->point]);
        }

        // case 2: user matching have suggested for current user

        if (in_array($matching_id, $top_suggest_id)) {
            $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));
            if ($suggested_item) {
                SuggestCModel::update_suggest($suggested_item->id, [
                    'status' => config('constant.suggest.status.liked'),
                    'updated_at' => date('Y-m-d', time())
                ]);
            }


            return ApiHelper::success(['message' => 'success', 'user_id' => null, 'remain_like' => $user_current->point]);
        }

        // case 3: user matching is discover by current user
        $discover_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.discover'));

        if ($discover_item) {
            if ($user_current->point < 1) {
                return ApiHelper::error(
                    config('constant.error_type.bad_request'),
                    config('constant.error_code.customer.point_not_enough'),
                    __('like.point_not_enough'),
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

            return ApiHelper::success(['message' => 'success', 'user_id' => null, 'remain_like' => $user_current->point - 1]);
        }

        return ApiHelper::error(
            config('constant.error_type.not_found'), 404,
            'user matching can not like',
            404
        );
    }

    public function pass(Request $request)
    {
        $user_id = $request->input('user_id');
        $matching_id = $request->input('matching_id');

        $user_current = CustomerQModel::get_user_by_id($user_id);
        $user_current_suggest = json_decode($user_current->_suggested);
        if (count($user_current_suggest) < 5) {
            $top_suggest_id = $user_current_suggest;
        } else {
            $top_suggest_id = [$user_current_suggest[0], $user_current_suggest[1], $user_current_suggest[2], $user_current_suggest[3] , $user_current_suggest[4]];
        }

        // check user matching
        $user_matching = CustomerQModel::get_user_by_id($matching_id);
        if (!$user_matching) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'user matching id not found',
                404
            );
        }

        $suggested_item = null;



        // case 1: user matching is suggested by current user
        if (in_array($matching_id, $top_suggest_id)) {
            $suggested_item = SuggestQModel::get_record_by_status($user_id, $matching_id, config('constant.suggest.status.suggested'));
        }

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

    public function unmatch(Request $request)
    {
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

        $value = FirebaseDatabaseHelper::get_firebase_connection()->getReference('Conversations')->getValue();
        $found = false;
        foreach($value as $item) {
            if(count($item) > 0 ) {
                $fromId = $item[key($item)]['fromID'];
                $toId = $item[key($item)]['toID'];
                if (($fromId == $user_id && $toId == $user_matching->id) ||
                    ($toId == $user_id && $fromId == $user_matching->id)
                ) {
                    $found = true;
                    break;
                }
            }
        }
        if ($found) {
            // When unmatch, two user will disabled each other
            FirebaseDatabaseHelper::get_firebase_connection()->getReference('Users')
                ->getChild($user_id.'/Conversations')
                ->getChild($user_matching->id.'/isDisabled')
                ->set(true);
            FirebaseDatabaseHelper::get_firebase_connection()->getReference('Users')
                ->getChild($user_matching->id.'/Conversations')
                ->getChild($user_id.'/isDisabled')
                ->set(true);
        }

        $item = SuggestQModel::get_unmatch_by_user_id($user_id, $matching_id);
        if ($item) {
            SuggestCModel::update_suggest($item->id, [
                'status' => config('constant.suggest.status.unmatch'),
                'updated_at' => date('Y-m-d', time())
            ]);
        } else {
            SuggestCModel::create_suggest([
                'user_id' => $user_id,
                'matching_id' => $matching_id,
                'status' => config('constant.suggest.status.unmatch'),
                'updated_at' => date('Y-m-d', time())
            ]);
        }

        return ApiHelper::success(['message' => 'success']);
    }

    public function list_unmatch(Request $request)
    {
        $user_id = $request->input('user_id');

        $list = SuggestQModel::get_list_unmatch_by_user_id($user_id);

        if (!$list) {
            return ApiHelper::success([]);
        }

        $list = ApiHelper::clear_data_member($list);

        return ApiHelper::success($list);
    }

    public function list_match(Request $request)
    {
        $user_id = $request->input('user_id');

        $list = SuggestQModel::get_list_match_by_user_id($user_id);

        if (!$list) {
            return ApiHelper::success([]);
        }

        $list = ApiHelper::clear_data_member($list);

        return ApiHelper::success($list);
    }

    public function list_who_likes_me(Request $request)
    {
        $user_id = $request->input('user_id');
        //print_r($user_id );
        $list = SuggestQModel::get_who_like_me($user_id);
        //print_r($list);
        $result = [];

        foreach ($list as $item) {
            $user = CustomerQModel::get_user_by_id($item->user_id);
            array_push($result, $user);
        }
        if (!$result) {
            return ApiHelper::success([]);
        }

        return ApiHelper::success($result);
    }

    public function suggest(Request $request)
    {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }

        $suggests = [];

        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $react = SuggestQModel::get_react_user($user->id);
        $react[] = $user_id;

        if (!empty($user->suggest_at) && $user->suggest_at == date('Y-m-d', $current_time)) {
            // get user in field suggested
            $result = SuggestQModel::get_current_suggest(config('constant.suggest.limit'), $user->_suggested, $user_id);
        } else {
            // get friend from table user
            $friends = $user->_friend ? json_decode($user->_friend) : [];

            // remove old suggest (not like, pass)
            SuggestCModel::reset_suggest($user_id);

            // get user like me to suggest
            $users_like_me = SuggestQModel::get_users_like_me($user_id, 30, $user);
            $user_like_me_ids = $users_like_me->pluck('id')->toArray();

            $suggests = array_merge($suggests, $user_like_me_ids);
            $txtFriends = implode(",", $friends);
            if (!$txtFriends) {
                $txtFriends = '0';
            }
            $listFriend = CustomerCModel::whereRaw("facebook_id IN ('" . $txtFriends . "')")->get();
            $friend_ids = $listFriend->pluck('id')->toArray();

            $friend_of_friends = $listFriend->pluck('_friend');
            $friend_of_friend_merge = [];
            foreach ($friend_of_friends as $i => $friends) {
                $friend_of_friends[$i] = json_decode($friends);
                $friend_of_friend_merge = array_merge($friend_of_friend_merge, json_decode($friends));
            }
            $friend_of_friend_merge = array_unique($friend_of_friend_merge);
            $friend_of_friend_merge_text = implode(",", $friend_of_friend_merge);
            if (!$friend_of_friend_merge_text) {
                $friend_of_friend_merge_text = '0';
            }
            $selectWeightPoint = "((CASE WHEN city = '" . $user->city . "' THEN 3 ELSE 0 END)";
            if ($user->birthday) {
                $selectWeightPoint .= "  + (CASE WHEN EXTRACT(YEAR FROM TO_DATE(birthday, 'DD-MM-YYYY')) BETWEEN EXTRACT(YEAR FROM TO_DATE('" . $user->birthday . "', 'DD-MM-YYYY')) - 5 AND EXTRACT(YEAR FROM TO_DATE('" . $user->birthday . "', 'DD-MM-YYYY')) + 5 THEN 2 ELSE 0 END) ";
            }
            $selectWeightPoint .= "+ (CASE WHEN country = '" . $user->country . "' THEN 1 ELSE 0 END)) as weightPoint";

            $listFriendOfFriends = CustomerCModel::select('*')->selectRaw($selectWeightPoint)->whereRaw("facebook_id IN ('" . $friend_of_friend_merge_text . "')")
                ->whereNotIn('id', $friend_ids)
                ->whereNotIn('id', $suggests)
                ->whereNotIn('id', $react)
                ->where('gender', '<>', $user->gender)
                ->orderByRaw('weightPoint DESC')
                ->get();
            $listFriendOfFriendIds = $listFriendOfFriends->pluck('id')->toArray();

            $react_unmatch_ids = SuggestQModel::get_list_unmatch_by_user_id($user->id);
            $react_unmatch_ids = array_map(function($u) {return $u->id;}, $react_unmatch_ids);

            $suggests = array_merge($suggests, $listFriendOfFriendIds);
            // get profile by city
            $suggests = $this->getProfileByCity($suggests, $user, $react, $react_unmatch_ids);
            // get profile by country
            $suggests = $this->getProfileByCountry($suggests, $user, $react, $react_unmatch_ids);

            // get profile by birthday
            $suggests = $this->getProfileByBirthday($suggests, $user, $react, $react_unmatch_ids);

            // get random profile
            $suggests = $this->getRandomProfile($suggests, $user, $react, $react_unmatch_ids);

            if (!empty($suggests)) {
                $data = [];
                $matching_ids = [];
                foreach ($suggests as $item) {
                    array_push($matching_ids, $item);

                    // if new suggest
                    array_push($data, [
                        'user_id' => $user_id,
                        'matching_id' => $item,
                        'status' => config('constant.suggest.status.suggested'),
                        'created_at' => date('Y-m-d', $current_time)
                    ]);
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
            $user = CustomerQModel::get_user_by_id($user_id);
            $result = SuggestQModel::get_current_suggest(config('constant.suggest.limit'), $user->_suggested, $user_id);
        }

        $result = ApiHelper::clear_data_member($result);

        return ApiHelper::success($result);
    }

    public function discover(Request $request)
    {
        $current_time = time();
        // test
        if ($request->input('time')) {
            $current_time = strtotime($request->input('time'));
        }

        $suggests = [];
        $this->suggest($request);
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
//         if (!empty($user->discover_at) && $user->discover_at == date('Y-m-d', $current_time)) {
// //            // get user in field suggested
//             $reacting = json_decode($user->_suggested);
//             if (count($reacting) < 4) {
//                 $reacting_id = $reacting;
                
//             } else {
//                 $reacting_id = [$reacting[0], $reacting[1], $reacting[2]];
//             }
//             $listDiscover = json_decode($user->__discover);
//             if (!empty($listDiscover)) {
//                 $suggests = SuggestQModel::get_current_discover($user_id, $reacting_id, $listDiscover);
//             }
//         } else {
            // remove old discover yesterday
            SuggestCModel::reset_discover($user_id);
            $suggestId = [];
            $react = SuggestQModel::get_react_user($user->id);
            $react_unmatch_ids = SuggestQModel::get_list_unmatch_by_user_id($user->id);
            $react_unmatch_ids = array_map(function($u) {return $u->id;}, $react_unmatch_ids);
            $react[] = $user_id;
            $reacting = json_decode($user->_suggested);
            if (count($reacting) < 4) {
                $reacting_id = $reacting;
                
            } else {
                $reacting_id = [$reacting[0], $reacting[1], $reacting[2]];
            }

            // get new discover
//            $result = SuggestQModel::get_new_discover($user);

            // get profile by city
            $suggestId = $this->getProfileByCity($suggestId, $user, $react, $react_unmatch_ids);
           
            // get profile by country
            $suggestId = $this->getProfileByCountry($suggestId, $user, $react, $react_unmatch_ids);

            // get profile by birthday
            $suggestId = $this->getProfileByBirthday($suggestId, $user, $react, $react_unmatch_ids);

            // get random profile
            $suggestId = $this->getRandomProfile($suggestId, $user, $react, $react_unmatch_ids);

            if (!empty($suggestId)) {
                $data = [];
                foreach ($suggestId as $item) {
                    array_push($data, [
                        'user_id' => $user_id,
                        'matching_id' => $item,
                        'status' => config('constant.suggest.status.discover'),
                        'created_at' => date('Y-m-d', $current_time)
                    ]);
                }

                // save list discover table suggest
                if (!empty($data)) {
                    SuggestCModel::create_suggest($data);
                }

                $suggests = SuggestQModel::get_current_discover($user_id, $reacting_id, $suggestId);

            }

            // update discover_at table customer
            CustomerCModel::update_user($user_id, [
                'discover_at' => date('Y-m-d', $current_time),
                '__discover' => json_encode($suggestId)
            ]);
        //}

        $suggests = ApiHelper::clear_data_member($suggests);

        return ApiHelper::success($suggests);
    }

    public function manual_friend(Request $request, $id)
    {
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $my_friend = CustomerQModel::get_user_by_id($id);

        $manual_friends = array_intersect(json_decode($user->_friend), json_decode($my_friend->_friend));
        $result = CustomerQModel::get_users_by_facebooks($manual_friends);

        $result = ApiHelper::clear_data_member($result);

        return ApiHelper::success($result);
    }

    public function push_user(Request $request, $matching_id)
    {
        $user_id = $request->input('user_id');
        $user = CustomerQModel::get_user_by_id($user_id);
        $user_matching = CustomerQModel::get_user_by_id($matching_id);

        $title = $request->input('title');
        $body = $request->input('body');
        $data = $request->input('data');
        $result = NotificationHelper::send($user_matching->fcm_token, [
            'title' => $title,
            'body' => ''
        ], $data);
        return ApiHelper::success(['message' => 'success']);
    }

    public function add_point(Request $request)
    {
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
                'point' => $user->point + 2,
                'old_point' => 1,
                'point_at' => date('Y-m-d', $current_time)
            ]);

            return ApiHelper::success(['message' => 'success add point new date']);
        } else {
            if ($user->old_point < 3) {
                //Increase 2 points
                //Old point as a counter just increase 1
                CustomerCModel::update_user($user_id, [
                    'point' => $user->point + 2,
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

    public function upload_avatar(Request $request)
    {
        $rules = array(
            'image' => 'required | mimes:jpeg,jpg,png',
            'location' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.customer.image_error_format'),
                $validator->messages(),
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

    public function delete_avatar(Request $request)
    {
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


    /**
     * @param $suggestId
     * @param $profile
     * @param $react
     * @param $user
     * @return array
     */
    protected function getProfileByCity($suggestId, $profile, $react, $react_unmatch_ids)
    {
        if (count($suggestId) < 30 && $profile->city) {
            $listIdProfileInCity = CustomerQModel::select('id')
                ->where('city', $profile->city)
                ->where('id', '<>', $profile->id)
                ->whereNotIn('id', $react)
                ->whereNotIn('id', $suggestId)
                ->whereNotIn('id', $react_unmatch_ids)
                ->orderByRaw("RANDOM()")
                ->where('gender', '<>', $profile->gender);
            if ($profile->birthday) {
                $listIdProfileInCity = $listIdProfileInCity->orderByRaw("ABS((TO_DATE(birthday, 'DD-MM-YYYY') - TO_DATE('" . $profile->birthday . "', 'DD-MM-YYYY'))) ASC");
            }
            $listIdProfileInCity = $listIdProfileInCity
                ->limit(30)
                ->get()
                ->pluck('id');
            if ($listIdProfileInCity) {
                $suggestId = $this->addUserIdToUserList($listIdProfileInCity, $profile->id, $suggestId);
            }
        }
        return $suggestId;
    }

    /**
     * @param $suggestId
     * @param $profile
     * @param $react
     * @param $user
     * @return array
     */
    protected function getProfileByCountry($suggestId, $profile, $react, $react_unmatch_ids)
    {
        if (count($suggestId) < 30 && $profile->country) {
            $listIdProfileInCountry = CustomerQModel::select('id')
                ->where('country', $profile->country)
                ->where('id', '<>', $profile->id)
                ->whereNotIn('id', $react)
                ->whereNotIn('id', $suggestId)
                ->whereNotIn('id', $react_unmatch_ids)
                ->where('gender', '<>', $profile->gender);
            if ($profile->birthday) {
                $listIdProfileInCountry = $listIdProfileInCountry->orderByRaw("ABS((TO_DATE(birthday, 'DD-MM-YYYY') - TO_DATE('" . $profile->birthday . "', 'DD-MM-YYYY'))) ASC");
            }

            $listIdProfileInCountry = $listIdProfileInCountry->limit(30)
                ->get()->pluck('id');
            if ($listIdProfileInCountry) {
                $suggestId = $this->addUserIdToUserList($listIdProfileInCountry, $profile->id, $suggestId);
            }
        }
        return $suggestId;
    }

    /**
     * @param $suggestId
     * @param $profile
     * @param $react
     * @param $user
     * @return array
     */
    protected function getProfileByBirthday($suggestId, $profile, $react, $react_unmatch_ids)
    {
        if (count($suggestId) < 30 && $profile->birthday) {
            $listInAgeRange = CustomerQModel::select('id')
                ->whereRaw("EXTRACT(YEAR FROM TO_DATE(birthday, 'DD-MM-YYYY')) BETWEEN EXTRACT(YEAR FROM TO_DATE('" . $profile->birthday . "', 'DD-MM-YYYY')) - 5 AND EXTRACT(YEAR FROM TO_DATE('" . $profile->birthday . "', 'DD-MM-YYYY')) + 5")
                ->whereNotIn('id', $react)
                ->whereNotIn('id', $suggestId)
                ->whereNotIn('id', $react_unmatch_ids)
                ->where('id', '<>', $profile->id)
                ->where('gender', '<>', $profile->gender)
                ->orderByRaw("ABS((TO_DATE(birthday, 'DD-MM-YYYY') - TO_DATE('" . $profile->birthday . "', 'DD-MM-YYYY'))) ASC")
                ->limit(30)
                ->get()->pluck('id');
            if ($listInAgeRange) {
                $suggestId = $this->addUserIdToUserList($listInAgeRange, $profile->id, $suggestId);
            }
        }
        return $suggestId;
    }

    /**
     * @param $suggestId
     * @param $profile
     * @param $react
     * @param $user
     * @return array
     */
    protected function getRandomProfile($suggestId, $profile, $react, $react_unmatch_ids)
    {
        if (count($suggestId) < 30) {
            $listRandomId = CustomerQModel::select('customers.id')
                ->whereNotIn('customers.id', $react)
                ->whereNotIn('customers.id', $suggestId)
                ->whereNotIn('customers.id', $react_unmatch_ids)
                ->where('customers.id', '<>', $profile->id)
                ->where('gender', '<>', $profile->gender)
                ->limit(30)
                ->get()->pluck('id');
            if ($listRandomId) {
                $suggestId = $this->addUserIdToUserList($listRandomId, $profile->id, $suggestId);
            }
        }

        return $suggestId;

    }

    /**
     * @param $idList
     * @param $idUser
     * @param $suggestId
     * @return array
     */
    protected function addUserIdToUserList($idList, $idUser, $suggestId)
    {
        foreach ($idList as $k => $id) {
            if ($id != $idUser && !in_array($id, $suggestId)) {
                $suggestId[] = $id;
            }
//            if (count($suggestId) == 3) break;
        }
        return $suggestId;
    }

    public function generate_branch_io_link($id, $name)
    {
        $link = new Link();
        $link->setType(UrlType::MARKETING);
        $link->setChannel('Sharing');
        $link->setFeature('Shareing');
        $link->setCampaign('Share Link Get Point');
        $link->setStage('Stage');
        $data = [
            '$always_deeplink' => true,
            '$ios_url' => env('IOS_LINK'),
            '$android_url' => env('ANDROID_LINK'),

            '$og_app_id' => env('BRANCH_IO_APP_ID'),
            '$og_title' => 'CafeLatteDev',
            '$og_description' => 'Ứng dụng cafelatte kết bạn ghép đôi!',
            '$og_image_url' => env('SHARE_LINK_IMAGE'),

            '$app_id' => $id,
            '$marketing_title' => $name . ' share link action'
        ];
        $link->setData($data);
        return Branchio::createLink($link);
    }


    public function get_link_data($link)
    {
        return Branchio::getLink($link);
    }


    /**
     * Send notification to other when give a message to them
     * @param $request request json
     * @return void
     */
    public function send_notification(Request $request)
    {
        $message = json_decode(request()->getContent(), true);

        $user_send_id = $message['fromID'];
        $user_send = CustomerQModel::get_user_by_id($user_send_id);
        $user_received_id = $message['toID'];
        $user_received = CustomerQModel::get_user_by_id($user_received_id);

        if(empty($user_send) || empty($user_received)) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'The requested user is not found',
                500
            );
        }

        $fcm_token = $user_received->fcm_token;

        if (empty($fcm_token)) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'receiver have no fcm token',
                500
            );
        }

        //Decide body content based on message type
        $message_type = $message['type'];
        $message_body = '';
        switch ($message_type) {
            case 'photo':
                $message_body = "Sent you a photo";
                break;
            case 'sticker':
                $message_body = "Sent you a sticker";
                break;
            default:
                $message_body = $message['content'];
        }

        $notification = [
            'title' => $user_send->name,
            'body' => $message_body,
            'sound' => true
        ];

        $result = NotificationHelper::send($fcm_token, $notification, request()->getContent());
        if ($result) {
            return ApiHelper::success(['message' => 'success']);
        } else {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'Fail to send notification',
                500
            );
        }

    }

    /**
     * Send notification to other when give a message to them (data payload only)
     * @param $request request json
     * @return void
     */
    public function send_notification_data_payload_only(Request $request)
    {
        $message = json_decode(request()->getContent(), true);

        $user_send_id = $message['fromID'];
        $user_send = CustomerQModel::get_user_by_id($user_send_id);
        $user_received_id = $message['toID'];
        $user_received = CustomerQModel::get_user_by_id($user_received_id);

        if(empty($user_send) || empty($user_received)) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'The requested user is not found',
                500
            );
        }

        $fcm_token = $user_received->fcm_token;

        if (empty($fcm_token)) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'receiver have no fcm token',
                500
            );
        }

        //Decide body content based on message type
        $message_type = $message['type'];
        $message_body = '';
        switch ($message_type) {
            case 'photo':
                $message_body = "Sent you a photo";
                break;
            case 'sticker':
                $message_body = "Sent you a sticker";
                break;
            default:
                $message_body = $message['content'];
        }

        $data = [
            'title' => $user_send->name,
            'body' => $message_body,
            'fromID' => $user_send_id,
            'type' => 'message'
        ];
        
        $result = NotificationHelper::send($fcm_token, null, $data);
        if ($result) {
            return ApiHelper::success(['message' => 'success']);
        } else {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'Fail to send notification',
                500
            );
        }

    }

    public function direct_message(Request $request)
    {
        $user_id = $request->input('user_id');
        $dm_id = $request->input('direct_message_to_id');

        if (empty($dm_id)) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.customer.remain_dm_not_enough'),
                'direct message to user id is invalid',
                400
            );
        }

        // check user will direct message
        $direct_message_user = CustomerQModel::get_user_by_id($dm_id);
        if (!$direct_message_user) {
            return ApiHelper::error(
                config('constant.error_type.not_found'), 404,
                'direct message to user id not found',
                404
            );
        }

        // get current
        $user_current = CustomerQModel::get_user_by_id($user_id);
        $user_current_dm = json_decode($user_current->__dm);
        $user_current_dm = $user_current_dm ? $user_current_dm : [];
        if (!empty($user_current_dm) && in_array($direct_message_user->id, $user_current_dm)) {
            return ApiHelper::success([
                'message' => 'success',
                'user_id' => $direct_message_user->id,
                'remain_direct_message' => $user_current->remain_direct_message
            ]);
        }
        if ($user_current->remain_direct_message == 0) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.customer.remain_dm_not_enough'),
                __('direct_message.remain_dm_not_enough'),
                400
            );
        }

        // decrease remain direct message user
        if (empty($user_current_dm)) {
            $user_current_dm = [$direct_message_user->id]; 
        } else {
            array_push($user_current_dm, $direct_message_user->id);
        }

        $remain_direct_message = $user_current->remain_direct_message - 1;

        CustomerCModel::update_user($user_id, [
            'remain_direct_message' => $remain_direct_message,
            '__dm' => json_encode($user_current_dm)
        ]);

        return ApiHelper::success([
            'message' => 'success',
            'direct_message_to_id' => $direct_message_user->id,
            'remain_direct_message' => $remain_direct_message
        ]);
    }
}