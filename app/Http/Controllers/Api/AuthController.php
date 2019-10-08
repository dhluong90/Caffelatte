<?php

namespace app\Http\Controllers\Api;

//use App\Http\Helpers\QuickBloxHelper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\CustomerCModel;
use App\Http\Models\Dal\CustomerQModel;
use Carbon\Carbon;
use Iivannov\Branchio\Support\UrlType;
use Illuminate\Http\Request;

use Iivannov\Branchio\Integration\Laravel\Facade\Branchio;
use Iivannov\Branchio\Link;

use \Firebase\JWT\JWT;
use Facebook\Facebook;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login_by_phone(Request $request)
    {
        $firebase_token = $request->input('firebase_token');

        if (!$firebase_token) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                'param wrong',
                400
            );
        }

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/cafe-latte-198808-firebase-adminsdk-l67b1-d8841a097d.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $auth = $firebase->getAuth();
        try {
            $verifiedIdToken = $auth->verifyIdToken($firebase_token);
        } catch (\InvalidToken $e) {
            return ApiHelper::error(
                config('constant.error_type.server_error'),
                config('constant.error_code.common.server_error'),
                'error: ' . $e->getMessage(),
                500
            );
        }
        $uid = $verifiedIdToken->getClaim('sub');
        $phone = $firebase->getAuth()->getUser($uid)->phoneNumber;

        // get current user
        $user = CustomerQModel::get_user_by_phone($phone);
        if ($user) {
            // login
            $jwt = [
                'id' => $user->id,
                'exp' => time() + config('constant.jwt.token_expire')
            ];
            $token = JWT::encode($jwt, env('JWT_KEY')); // JWT::decode($token, env('JWT_KEY'), ['HS256']);

            $data_update = [
                'phone' => $phone,
                'firebase_uid' => $uid,
                'token' => $token,
                'login_at' => date('Y-m-d H:i:s')
            ];
            // moved branch io to set up at the end of process
            CustomerCModel::update_user($user->id, $data_update);
            $user = CustomerQModel::get_user_by_phone($phone);
            return ApiHelper::success($user);
        } else {
            // signup
            try {
                // moved quickblox to set up to the end of process
                $data = [
                    'phone' => $phone,
                    'firebase_uid' => $uid,
                    'login_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'point' => 50
                ];

                $user_id = CustomerCModel::create_user($data);

                // setup jwt to update token
                $jwt = [
                    'id' => $user_id,
                    'exp' => time() + config('constant.jwt.token_expire')
                ];
                $token = JWT::encode($jwt, env('JWT_KEY')); // JWT::decode($token, env('JWT_KEY'), ['HS256']);
                $data_update = ['token' => $token];
                // moved branch io to set up at the end of process
                CustomerCModel::update_user($user_id, $data_update);
            } catch (\Exception $e) {
                return ApiHelper::error(
                    config('constant.error_type.server_error'),
                    config('constant.error_code.common.server_error'),
                    'error: ' . $e->getMessage(),
                    500
                );
            }
            $user = CustomerQModel::get_user_by_phone($phone);
            return ApiHelper::success($user);
        }
    }

    public function login(Request $request)
    {
        $facebook_token = $request->input('facebook_token');
        $uid = $request->input('firebase_uid');

        if (!$facebook_token) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.param_wrong'),
                'param wrong',
                400
            );
        }

        $fb = new Facebook([
            'app_id' => config('facebook.id'),
            'app_secret' => config('facebook.secret')
        ]);

        try {
            $response = $fb->get('/me?fields=id,name,email,link,birthday', $facebook_token); // get user facebook
            $profile = $response->getGraphUser();

            // facebook_token error
            if (!$profile || !isset($profile['id'])) {
                return ApiHelper::error(config('constant.error_type.bad_request'),
                    config('constant.error_code.auth.get_profile_error'),
                    'get profile facebook error',
                    400
                );
            }
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.login_facebook_failed'),
                'Login facebook failed: ' . $e->getMessage(),
                400
            );
        }

        $friends = [];

        try {
            $response = $fb->get('/me/friends?limit=4000', $facebook_token);
            $graphEdge = $response->getGraphEdge();
            foreach ($graphEdge as $graphNode) {
                array_push($friends, $graphNode['id']);
            }
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.get_friend_facebook_failed'),
                'Get friends facebook failed: ' . $e->getMessage(),
                400
            );
        }

        // get current user
        $user = CustomerQModel::get_user_by_facebook_id($profile['id']);

        if ($user) {
            // login
            $jwt = [
                'id' => $user->id,
                'exp' => time() + config('constant.jwt.token_expire')
            ];
            $token = JWT::encode($jwt, env('JWT_KEY')); // JWT::decode($token, env('JWT_KEY'), ['HS256']);

            $data_update = [
                'token' => $token,
                'facebook_token' => $facebook_token,
                'firebase_uid' => $uid,
                '_friend' => json_encode($friends),
                'login_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$user->share_link) {
                $share_link = $this->generate_branch_io_link($user->id, $user->name);
                $detail_link = $this->get_link_data($share_link);
                $data_update['share_link_id'] = $detail_link->data->{'~id'};
                $data_update['share_link'] = $share_link;
                $data_update['share_link_created_at'] = Carbon::now();
            }


            CustomerCModel::update_user($user->id, $data_update);

            $user = CustomerQModel::get_user_by_facebook_id($profile['id']);


            return ApiHelper::success($user);
        } else {
            // signup
            try {
                //$quickBlox = new QuickBloxHelper();
                $userEmail = $profile['id'].'@facebook.com';
                if (isset($profile['email'])) {
                    $userEmail = $profile['email'];
                }
                //$chatId = $quickBlox->createNewUser($userEmail, $profile['id'], $profile['name']);
                $data = [
                    'name' => $profile['name'],
                    'image' => json_encode(['https://graph.facebook.com/' . $profile['id'] . '/picture?type=large&width=720&height=720']),
                    'facebook_id' => $profile['id'],
                    'email' => $userEmail,
                    'firebase_uid' => $uid,
                    'facebook_token' => $facebook_token,
                    '_friend' => json_encode($friends),
                    'login_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'point' => 50
                ];


                $user_id = CustomerCModel::create_user($data);

                // setup jwt to update token
                $jwt = [
                    'id' => $user_id,
                    'exp' => time() + config('constant.jwt.token_expire')
                ];

                $token = JWT::encode($jwt, env('JWT_KEY')); // JWT::decode($token, env('JWT_KEY'), ['HS256']);

                $data_update = ['token' => $token];

                $share_link = $this->generate_branch_io_link($user_id, $data['name']);
                $detail_link = $this->get_link_data($share_link);
                $data_update['share_link_id'] = $detail_link->data->{'~id'};
                $data_update['share_link'] = $share_link;
                $data_update['share_link_created_at'] = Carbon::now();

                CustomerCModel::update_user($user_id, $data_update);
            } catch (\Exception $e) {
                return ApiHelper::error(
                    config('constant.error_type.server_error'),
                    config('constant.error_code.common.server_error'),
                    'error: ' . $e->getMessage(),
                    500
                );
            }

            $user = CustomerQModel::get_user_by_facebook_id($profile['id']);



            return ApiHelper::success($user);
        }
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
}