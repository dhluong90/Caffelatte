<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\FoodCModel;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Dal\FoodTagQModel;
use App\Http\Models\Dal\CategoryQModel;
use App\Http\Models\Dal\FoodCategoryQModel;
use App\Http\Models\Dal\StoreUserCModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Models\Business\UserModel;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\Constants;
use App\Http\Helpers\ImageHelper;
use Auth;

class ManageStoreController extends PageController {

    /**
     * Display interface create
     * @param  int  $store_id
     * @return \Illuminate\Http\Response
     */
    public function create_food($store_id) {
        // Get store
        $data['store'] = StoreQModel::get_store_by_id($store_id);
        if (!$data['store']) {
            return view('vendor.adminlte.errors.404');
        }

        //Get all tags
        $data['tags'] = TagQModel::get_all_tags();

        //Get all categories
        $data['categories'] = CategoryQModel::get_categories();

        $data['count_foods'] = FoodQModel::count_food_by_store_id($store_id);
        $data['page_active'] = 'san_pham';

        return view('pages.manage-store.create_food', $data);
    }

    /**
     * Store a food created in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $store_id
     * @return \Illuminate\Http\Response
     */
    public function post_create_food(Request $request, $store_id) {
        // Check id error
        if (!$store_id  || !is_numeric($store_id)) {
            $request->session()->flash('alert-danger', 'Món ăn tạo không thành công!');
            return back();
        }

        // Custom validation
        $validate_check = [
            'food-logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'food-name' => 'required',
            'food-description' => 'required',
            'food-step-title.*' => 'required',
            'food-step-time.*' => 'required',
            'food-step-description.*' => 'required',
            'food-link.*' => 'required',
            'food-category' => 'required',
            'tags.*' => 'required',
        ];

        if ($_POST['opt_price'] == 'one-price') {
            $validate_check['food-price'] = 'required|integer|min:0';
            $food_price = $_POST['food-price'];
        } else {
            $validate_check['food-price-from'] = 'required|integer|min:0';
            $validate_check['food-price-to'] = 'required|integer|min:0|greater_than_field:food-price-from';
            $food_price_from = $_POST['food-price-from'];
            $food_price_to = $_POST['food-price-to'];
        }
        // Validate and store the food
        $this->validate($request, $validate_check);

        // get input image logo
        $file = Input::file('food-logo');

        // Create item to insert db
        $data['food'] = [
            'name' => $_POST['food-name'],
            'images' => ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['food']),
            'detail' => $_POST['food-description'],
            'status' => UserModel::check_manager(Auth::id()) ? Constants::FOOD_APPROVE : Constants::FOOD_PENDING,
            'slug' => str_slug($_POST['food-name']),
            'user_id' => Auth::user()->id,
            'store_id' => $store_id,
            'created_at' => time(),
        ];

        // Check price option
        if (!empty($food_price)) {
            $data['food']['price'] = $food_price;
            $data['food']['price_max'] = $food_price;
        } else {
            $data['food']['price'] = $food_price_from;
            $data['food']['price_max'] = $food_price_to;
        }

        //Create guides to store DB
        $guides = [];
        foreach ($_POST["food-step-title"] as $key => $value) {
            $guide = [
                'title' => $_POST["food-step-title"][$key],
                'time' => $_POST["food-step-time"][$key]
            ];
            array_push($guides, $guide);
        }
        $data['food']['guides'] = json_encode($guides);
        
        //Create steps to store DB
        $steps = [];
        foreach ($_POST["food-step-description"] as $step) {
            array_push($steps, $step);
        }
        $data['food']['steps'] = json_encode($steps);
        //Create links to store DB
        $links = [];
        foreach ($_POST["food-link"] as $link) {
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $link_temp);
            if (!empty($link_temp[0])) {
                $link_id = $link_temp[0];
                array_push($links, $link_id);
            } else {
                $request->session()->flash('alert-danger', 'Link Youtube không đúng định dạng!');
                return back();
            }
        }
        if (count($links) > 0) {
            $data['food']['videos'] = json_encode($links);
        }

        $data['tag'] = $_POST["tags"];

        $data['category'] = $_POST["food-category"];

        if (FoodModel::create_food($data)) {
            $request->session()->flash('alert-success', 'Món ăn đã được tạo thành công, vui lòng chờ admin duyệt!');
            return redirect('/manage/store/'.$store_id.'/food');
        } else {
            // delete image
            ImageHelper::delete_image($data->images, Constants::MANAGE_IMAGE['food']);

            $request->session()->flash('alert-danger', 'Món ăn tạo không thành công!');
            return back();
        }
    }

    /**
     * Display interface create
     * @param  int  $store_id, int  $food_id
     * @return \Illuminate\Http\Response
     */
    public function edit_food($store_id, $food_id) {
        // Get food
        $data['food'] = FoodQModel::get_food_by_id($food_id);
        if (!$data['food']) {
            return view('vendor.adminlte.errors.404');
        }

        // Get existed tags by food id
        $data['existed_tags'] = FoodTagQModel::get_tags_by_food_id($food_id);

        // Get all tags except existed tags
        $data['all_tags'] = TagQModel::get_all_tags_except_existed_tags_by_food_id($food_id);

        // Get all categories
        $data['categories'] = CategoryQModel::get_categories();

        //Get food's category
        $data['food_category'] = FoodCategoryQModel::get_categories_by_food_id($food_id);

        $data['count_foods'] = FoodQModel::count_food_by_store_id($store_id);
        $data['page_active'] = 'san_pham';

        $data['price_max'] = Constants::FOOD_PRICE_MAX;

        return view('pages.manage-store.edit_food', $data);
    }

    /**
     * Update a food in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $store_id, int  $food_id
     * @return \Illuminate\Http\Response
     */
    public function post_edit_food(Request $request, $store_id, $food_id) {
        // Check id error
        if (!$food_id  || !is_numeric($food_id) || !$store_id  || !is_numeric($store_id)) {
            $request->session()->flash('alert-danger', 'Món ăn cập nhật không thành công!');
            return back();
        }

        // Validate require tag
        if (empty($_POST['tags'])) {
            $request->session()->flash('alert-danger', 'Vui lòng chọn tag!');
            return back();
        }

        // Custom validation
        $validate_check = [
            'food-logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'food-name' => 'required',
            'food-description' => 'required',
            'food-step-title.*' => 'required',
            'food-step-time.*' => 'required',
            'food-step-description.*' => 'required',
            'food-link.*' => 'required',
            'food-category' => 'required',
            'tags.*' => 'required',
        ];

        if ($_POST['opt_price'] == 'one-price') {
            $validate_check['food-price'] = 'required|numeric|min:0|max:100000000';
            $food_price = $_POST['food-price'];
        } else {
            $validate_check['food-price-from'] = 'required|integer|min:0';
            $validate_check['food-price-to'] = 'required|integer|min:0|greater_than_field:food-price-from';
            $food_price_from = $_POST['food-price-from'];
            $food_price_to = $_POST['food-price-to'];
        }

        // Validate and store the food
        $this->validate($request, $validate_check);

        // Create data_model to update to DB
        $data['food'] = [
            'name' => $_POST['food-name'],
            'detail' => $_POST['food-description'],
            'slug' => str_slug($_POST['food-name']),
            'store_id' => $store_id,
            'updated_at' => time(),
        ];

        // Check price option
        if (!empty($food_price)) {
            $data['food']['price'] = $food_price;
            $data['food']['price_max'] = $food_price;
        } else {
            $data['food']['price'] = $food_price_from;
            $data['food']['price_max'] = $food_price_to;
        }

        //Create guides to store DB
        $guides = [];
        foreach ($_POST["food-step-title"] as $key => $value) {
            $guide = [
                'title' => $_POST["food-step-title"][$key],
                'time' => $_POST["food-step-time"][$key]
            ];
            array_push($guides, $guide);
        }
        $data['food']['guides'] = json_encode($guides);

        //Create steps to store DB
        $steps = [];
        foreach ($_POST["food-step-description"] as $step) {
            array_push($steps, $step);
        }
        $data['food']['steps'] = json_encode($steps);

        //Create links to store DB
        $links = [];
        foreach ($_POST["food-link"] as $link) {
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $link_temp);
            if (!empty($link_temp[0])) {
                $link_id = $link_temp[0];
                array_push($links, $link_id);
            } else {
                $request->session()->flash('alert-danger', 'Link Youtube không đúng định dạng!');
                return back();
            }
        }
        if (count($links) > 0) {
            $data['food']['videos'] = json_encode($links);
        }

        // Check update file
        if ($request->hasFile('food-logo')) {
            $file = Input::file('food-logo');
            $data['food']['images'] = ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['food']);
        }

        $data['tags'] = $_POST["tags"];

        $data['category'] = $_POST["food-category"];

        // Process update food
        if (FoodModel::update_food($food_id, $data)) {
            $request->session()->flash('alert-success', 'Món ăn đã được cập nhật thành công, vui lòng chờ admin duyệt!');
            return redirect('/manage/store/'.$store_id.'/food');
        } else {
            $request->session()->flash('alert-success', 'Món ăn cập nhật không thành công!');
            return back();
        }
    }

    /**
    * Get list food by store id
    * @param $store_id int
    * @return view list foods
    */
    public function list_food($store_id) {
        $data['foods'] = FoodQModel::get_foods_by_store_id($store_id);
        if (!$data['foods']) {
            return view('vendor.adminlte.errors.404');
        }

        $data['count_foods'] = FoodQModel::count_food_by_store_id($store_id);
        $data['page_active'] = 'san_pham';
        $data['menu'] = [
            'store_id' => $store_id,
        ];

        return view('pages.manage-store.list_food', $data);
    }

    /**
     * Show interface edit store
     * @param $store_id int
     * @return view edit store
     */
    public function edit_store($store_id) {
        $data['store'] = StoreQModel::get_store_by_store_id($store_id);

        if (!$data['store']) {
            return view('vendor.adminlte.errors.404');
        }

        $data['count_foods'] = FoodQModel::count_food_by_store_id($store_id);
        $data['page_active'] = 'cua_hang';

        return view('pages.manage-store.edit_store', $data);
    }

    /**
    * Process update store
    * @param $store_id int
    * @param $request Request
    * @return reponse update data in database
    */
    public function post_edit_store(Request $request, $store_id) {
        // Check id error
        if (!$store_id  || !is_numeric($store_id)) {
            $request->session()->flash('alert-danger', 'Cửa hàng cập nhật không thành công!');
            return back();
        }

        // Validate store
        $this->validate($request, [
            'store-logo' => 'image|mimes:jpeg,jpg,png,svg|max:10000',
            'store-name' => 'required',
            'store-introduction' => 'required',
            'store-sector' => 'required',
            'store-address' => 'required',
            'store-phone' => 'required',
            'store-open-time' => 'required',
            'store-close-time' => 'required',
            'store-open-day' => 'required',
            'store-close-day' => 'required',
            'store-branch.*' => 'required',
        ]);

        // Get store
        $store = StoreQModel::get_store_by_store_id($store_id);

        // Define store-slug
        $slug = str_slug($_POST['store-name']);

        $data = [
            'open_time' => $_POST['store-open-time'],
            'close_time' => $_POST['store-close-time'],
            'open_day' => $_POST['store-open-day'],
            'close_day' => $_POST['store-close-day'],
            'name' => $_POST['store-name'],
            'introduction' => $_POST['store-introduction'],
            'sector' => $_POST['store-sector'],
            'address' => $_POST['store-address'],
            'phone' => $_POST['store-phone'],
            'facebook' => $_POST['store-facebook'],
            'site_url' => $_POST['store-site-url'],
            'email' => $_POST['store-email'],
            'branch' => isset($_POST['store-branch']) ? json_encode($_POST['store-branch']) : '',
            'slug' => $slug,
            'updated_at' => time()
        ];

        // Check update file
        if ($request->hasFile('store-logo')) {
            $file = Input::file('store-logo');
            $data['logo'] = ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['store']);
        }
        // Process update
        if (StoreCModel::update_store($store_id, $data)) {
            if (!empty($data['logo'])) {
                ImageHelper::delete_image($store->logo, Constants::MANAGE_IMAGE['store']);
            }

            $request->session()->flash('alert-success', 'Cửa hàng đã được cập nhật thành công, vui lòng chờ admin duyệt!');
            return redirect('/profile/'.Auth::user()->id.'/store');
        } 
        return back();
    }

    /**
     * Delete a store.
     *
     * @param $store_id int
     * @param Request $request
     * @return Response
     */
    public function delete_store(Request $request, $store_id) {
        // Check input id error
        if (!$store_id  || !is_numeric($store_id)) {
            $request->session()->flash('alert-danger', 'Cửa hàng xóa không thành công!');
            return back();
        }

        // Get store by id
        $store = StoreQModel::get_store_by_id($store_id);
        if (!$store) {
            return view('vendor.adminlte.errors.404');
        }

        // Process delete store
        if (StoreCModel::delete_store($store_id)) {
            // Delete old image
            ImageHelper::delete_image($store->logo, Constants::MANAGE_IMAGE['store']);

            // Delete foods of store
            FoodCModel::delete_foods_by_store_id($store_id);

            // Delete store user
            StoreUserCModel::delete_store_user_by_store_id($store_id);

            $request->session()->flash('alert-success', 'Cửa hàng đã được xóa thành công!');
            return redirect('/profile/' . Auth::user()->id . '/store');
        } else {
            $request->session()->flash('alert-success', 'Cửa hàng xóa không thành công!');
            return back();
        }
    }

    /**
     * Delete a food.
     *
     * @param $store_id int, $food_id int
     * @param Request $request
     * @return Response
     */
    public function delete_food(Request $request, $store_id, $food_id) {
        // Check input id error
        if (!$food_id  || !is_numeric($food_id)) {
            $request->session()->flash('alert-danger', 'Món ăn xóa không thành công!');
            return back();
        }

        // Get food by id
        $food = FoodQModel::get_food_by_id($food_id);
        if (!$food) {
            return view('vendor.adminlte.errors.404');
        }

        // Process delete food
        if (FoodCModel::delete_food($food_id)) {
            // Delete old image.
            ImageHelper::delete_image($food->images, Constants::MANAGE_IMAGE['food']);

            $request->session()->flash('alert-success', 'Món ăn đã được xóa thành công!');
            return redirect('/manage/store/' . $food->store_id . '/food');
        } else {
            $request->session()->flash('alert-success', 'Món ăn xóa không thành công!');
            return back();
        }
    }
}
