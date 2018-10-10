<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\UserCModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Models\Dal\CustomerQModel;

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

    public function update_image(Request $request) {
        $user_sucess = [];
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            UserCModel::update_user($user->id, [
                'image' => json_encode(['https://graph.facebook.com/'.$user->facebook_id.'/picture?type=large&width=720&height=720'])
            ]);
            array_push($user_sucess, [$user->id => 'success']);
        }
        return ApiHelper::success($user_sucess);
    }

}