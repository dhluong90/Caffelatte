<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\UserQModel;

use Facebook\Facebook;

/**
 * Class ToolController
 * @package App\Http\Controllers\Api
 */
class ToolController extends Controller
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

    public function update_friend(Request $request) {

        $user_sucess = [];
        $users = DB::table('users')->get();

        $fb = new Facebook([
            'app_id' => config('facebook.id'),
            'app_secret' => config('facebook.secret')
        ]);

        foreach ($users as $user) {
            $friends = [];
            try {
                $response = $fb->get('/me/friends?limit=4000', $user->facebook_token);
                $graphEdge = $response->getGraphEdge();
                foreach ($graphEdge as $graphNode) {
                    array_push($friends, $graphNode['id']);
                }

                UserCModel::update_user($user->id, [
                    '_friend' => json_encode($friends)
                ]);

                array_push($user_sucess, [$user->id => 'success']);

            } catch (\Exception $e) {
                array_push($user_sucess, [$user->id => $e->getMessage()]);
            }
        }

        return ApiHelper::success($user_sucess);
    }
}