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
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Models\Dal\CustomerCModel;
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
        $data['keyword'] = $keyword;
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

    /**
     * Show user profile.
     * @param $request Request
     * @return Response
     */
    public function get_user_profile($customer_id, Request $request) {
        $profile = CustomerQModel::get_user_by_id($customer_id);
        if (!$profile) {
            $request->session()->flash('alert-danger', 'Member is not exist!');
        }
        $list_image = $profile->image;
        $list_image = json_decode($list_image);
        $avatar = $list_image[0];
        $data['profile'] = $profile;
        $data['avatar'] = $avatar;
//        dd($profile);
        return view('vendor.adminlte.user.profile', $data);
    }

    /**
     * update profile user
     * @param $user_id int
     * @return view response
     */
    public function update_user_profile($user_id, Request $request) {
        // Check id error
        if (!$user_id  || !is_numeric($user_id) || $user_id != Auth::id()) {
            $request->session()->flash('alert-danger', 'Thông tin cập nhật không thành công!');
            return back();
        }

        // Validate profile
        $this->validate($request, [
            'profile-name' => 'required',
            'profile-re-new-password' => 'same:profile-new-password',
            'profile-old-password' => 'required_with:profile-new-password,profile-re-new-password'
        ]);

        $data = [
            'name' => $_POST['profile-name']
        ];

        // if user update password
        if (!empty($_POST['profile-new-password'])) {
            //Check if old password is correct
            if (UserModel::login(Auth::user()->email, $_POST['profile-old-password'])) {
                $data['password'] = bcrypt($_POST['profile-new-password']);
            } else {
                $request->session()->flash('alert-danger', 'Vui lòng kiểm tra lại mật khẩu cũ!');
                return back();
            }
        }

        // Process update 
        if (UserCModel::update_user($user_id, $data)) {
            $request->session()->flash('alert-success', 'Thông tin đã được cập nhật thành công!');
            return redirect('admincp/user/profile/'.$user_id);
        } 
        return back();
    }

    /**
     * clear_suggest.
     * @param $request Request
     * @return Response
     */
    public function clear_suggest(Request $request) {
        $data['users'] = CustomerQModel::get_all_user();
        foreach($data['users'] as $member) {
            CustomerCModel::update_user($member->id, [
                'suggest_at' => null,
                'discover_at' => null,
                'point_at' => null,
            ]);
        }
        return back();
    }

}