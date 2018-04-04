<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\StoreUserQModel;
use App\Http\Models\Dal\StoreUserCModel;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;
use Auth;

class ProfileController extends PageController
{
    /**
     * Show user profile
     * @param $user_id int
     * @return view response
     */
    public function detail_user($user_id) {
        // setup menu
        $data['user_id'] = $user_id;
        $data['count_stores'] = StoreUserQModel::count_stores_by_user_id($user_id);

        $data['user'] = UserQModel::get_user_by_id($user_id);
        $data['page_active'] = 'thong_tin_nguoi_dung';
        $data['can_manage_profile'] = $user_id == Auth::id() ? TRUE : FALSE;

        return view('pages.profile.detail_user', $data);
    }

    /**
     * Show profile user by user id
     * @param $user_id int
     * @return view response
     */
    public function edit_user($user_id) {
        // setup menu
        $data['user_id'] = $user_id;
        $data['count_stores'] = StoreUserQModel::count_stores_by_user_id($user_id);

        $data['user'] = UserQModel::get_user_by_id($user_id);

        $data['page_active'] = 'thong_tin_nguoi_dung';

        if (!$data['user']) {
            return view('vendor.adminlte.errors.404');
        }

        return view('pages.profile.edit_user', $data);
    }

    /**
     * update profile user
     * @param $user_id int
     * @return view response
     */
    public function update_user(Request $request, $user_id) {
        // Check id error
        if (!$user_id  || !is_numeric($user_id)) {
            $request->session()->flash('alert-danger', 'Thông tin cập nhật không thành công!');
            return back();
        }

        // Validate profile
        $this->validate($request, [
            'profile-image' => 'image|mimes:jpeg,jpg,png,svg|max:10000',
            'profile-name' => 'required',
            'profile-re-new-password' => 'same:profile-new-password',
            'profile-old-password' => 'required_with:profile-new-password,profile-re-new-password',
            'profile-phone' => 'sometimes|nullable|numeric'
        ]);

        $data = [
            'name' => $_POST['profile-name'],
            'phone' => $_POST['profile-phone']
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

        // Check update file
        if ($request->hasFile('profile-image')) {
            $file = Input::file('profile-image');
            $data['image'] = ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['user']);
        }

        // Get user
        $user = UserQModel::get_user_by_id($user_id);

        // Process update 
        if (UserCModel::update_user($user_id, $data)) {
            //Delete old image file
            if (!empty($data['image'])) {
                ImageHelper::delete_image($user->image, Constants::MANAGE_IMAGE['user']);
            }

            $request->session()->flash('alert-success', 'Thông tin đã được cập nhật thành công!');
            return redirect('/profile/'.$user_id);
        } 
        return back();
    }

    /**
    * Show user's stores
    * @param $user_id
    * @return list store 
    */
    public function list_store($user_id) {
        // setup menu
        $data['user_id'] = $user_id;
        $data['count_stores'] = StoreUserQModel::count_stores_by_user_id($user_id);

        $stores = StoreQModel::get_stores_by_user_id($user_id);
        if( !$stores || !$user_id || !is_numeric($user_id)) {
            return view('vendor.adminlte.errors.404');
        }

        $count_food = 0;
        foreach ($stores as $store) {
            $count_food = FoodQModel::count_food_by_store_id($store->id);
            $store->count_food =  $count_food ;
        }
        $data['stores'] = $stores;

        $data['page_active'] = 'cua_hang';

        $data['can_manage_store'] = $user_id == Auth::id() || UserModel::check_manager(Auth::id()) ? TRUE : FALSE;

        return view('pages.profile.list_stores', $data);
    }

    /**
    * Display page create store
    * @return Reponse page html
    */
    public function create_store($user_id) {
        // setup menu
        $data['user_id'] = $user_id;
        $data['count_stores'] = StoreUserQModel::count_stores_by_user_id(Auth::user()->id);

        $data['page_active'] = 'cua_hang';

        return view('pages.profile.create_store', $data);
    }

    /**
    * Save store
    * @param Request $request
    * @return Reponse 
    */
    public function post_create_store(Request $request) {
        // Validate store
        $this->validate($request, [
            'store-logo' => 'image|mimes:jpeg,jpg,png,svg|required|max:3000',
            'store-name' => 'required',
            'store-introduction' => 'required',
            'store-sector' => 'required',
            'store-address' => 'required',
            'store-phone' => 'required|numeric',
            'store-open-time' => 'required',
            'store-close-time' => 'required',
            'store-open-day' => 'required',
            'store-close-day' => 'required',

        ]);
        // Define store-slug
        $slug = str_slug($_POST['store-name']);
        // Get input image logo
        $file = input::file('store-logo');

        $data = [
            'logo' => imageHelper::upload_image($file, Constants::MANAGE_IMAGE['store']),
            'open_time' => $_POST['store-open-time'],
            'close_time' => $_POST['store-close-time'],
            'open_day' => $_POST['store-open-day'],
            'close_day' => $_POST['store-close-day'],
            'name' => $_POST['store-name'],
            'introduction' => $_POST['store-introduction'],
            'status' => UserModel::check_manager(Auth::id()) ? Constants::STORE_APPROVE : Constants::STORE_PENDING,
            'sector' => $_POST['store-sector'],
            'address' => $_POST['store-address'],
            'phone' => $_POST['store-phone'],
            'facebook' => $_POST['store-facebook'],
            'site_url' => $_POST['store-site-url'],
            'email' => $_POST['store-email'],
            'branch' => isset($_POST['store-branch']) ? json_encode($_POST['store-branch']) : '',
            'slug' => $slug,
            'created_at' => time(),
        ];

        // Process insert
        $last_store_id = StoreCModel::insert_store($data);
        if ($last_store_id) {
            $data_store_user = [
                'user_id' => Auth()->user()->id,
                'store_id' => $last_store_id,
                'role' => Constants::STORE_ROLE_OWNER
            ];
            // Save store user
            if (StoreUserCModel::insert_store_user($data_store_user)) {
                $request->session()->flash('alert-success', 'Cửa hàng đã được tạo thành công, vui lòng chờ admin duyệt!');
                return redirect('/profile/'.$request->user_id.'/store');
            } else {
                // delete image
                ImageHelper::delete_image($data->logo, Constants::MANAGE_IMAGE['store']);
                // delete store
                StoreCModel::delete_store($last_store_id);

                $request->session()->flash('alert-success', 'Cửa hàng tạo không thành công!');
                return back();
            }
        } else {
            // delete image
            ImageHelper::delete_image($data->logo, Constants::MANAGE_IMAGE['store']);

            $request->session()->flash('alert-success', 'Cửa hàng tạo không thành công!');
            return back();
        }
    }
}