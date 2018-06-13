<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\CustomerQModel;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\Constants;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{

    /**
     * Show member.
     * @param $request Request
     * @return Response
     */
    public function list_member(Request $request) {
        $keyword = '';
        if (isset($_GET['q'])) {
            $keyword = $_GET['q'];
        }

        $data['users'] = CustomerQModel::search_user_paging($keyword);
        return view('vendor.adminlte.user.list_member', $data);
    }

    /**
     * Show member.
     * @param $request Request
     * @return Response
     */
    public function list_admin(Request $request) {
        $keyword = '';
        if (isset($_GET['q'])) {
            $keyword = $_GET['q'];
        }

        $data['users'] = UserQModel::search_user_paging(Constants::ROLES['admin'], $keyword);
        return view('vendor.adminlte.user.list_admin', $data);
    }

    /**
     * Set admin for user
     * @param user_id
     * @return boolean
     */
    public function set_admin($user_id, Request $request) {
        // Check id error
        if (!$user_id  || !is_numeric($user_id)) {
            $request->session()->flash('alert-danger', 'Cấp quyền không thành công!');
            return back();
        }

        // Process update
        if (UserCModel::update_user($user_id, ['role' => Constants::ROLES['admin']])) {
            $request->session()->flash('alert-success', 'Cấp quyền thành công!');
            return back();
        }
    }

    /**
     * Set admin for user
     * @param user_id
     * @return boolean
     */
    public function unset_admin($user_id, Request $request) {
        // Check id error
        if (!$user_id  || !is_numeric($user_id)) {
            $request->session()->flash('alert-danger', 'Hủy quyền admin không thành công!');
            return back();
        }

        // Process update
        if (UserCModel::update_user($user_id, ['role' => Constants::ROLES['member']])) {
            $request->session()->flash('alert-success', 'Hủy quyền admin thành công!');
            return back();
        }
    }

}