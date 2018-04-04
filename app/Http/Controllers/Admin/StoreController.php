<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\UrlGenerator;
use Intervention\Image\ImageManagerStatic;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\StoreUserCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\FoodCModel;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

class StoreController extends Controller
{
    /**
     * Show list approved stores.
     * 
     * @return Response
     */
    public function index() {
        $stores = StoreQModel::get_approved_stores_paging();
        return view('vendor.adminlte.store.list',compact('stores'));
    }

    /**
     * Search approved stores
     *
     * @param string $search
     * @param Request $request
     * @return Response
     */
    public function search_list_approved_stores(Request $request) {
        
        $search = Input::get('search-store');
        if (!empty($search)) {
            $stores = StoreQModel::search_approved_stores_paging($search);
            $pagination = $stores->appends(array(
                'search-store' => Input::get('search-store')
            ));
            if(empty($stores[0])) {
                $request->session()->flash('alert-danger', 'Cửa hàng này không có trong danh sách các cửa hàng đã duyệt !');
                return back();
            } else {
                return view('vendor.adminlte.store.list',compact('stores'));
            }
        }
        return back();
    }

    /**
     * Show list pending stores.
     *
     *
     * @param Request $request
     * @return Response
     */
    public function list_pending_stores(Request $request) {

        // Get stores
        $stores = StoreQModel::get_pending_stores_paging();
        return view('vendor.adminlte.store.list_pending',compact('stores'));
    }

    /**
     * Search pending stores
     *
     * @param string $search
     * @param Request $request
     * @return Response
     */
    public function search_list_pending_stores(Request $request) {
        
        $search = Input::get('search-store');
        if (!empty($search)) {
            $stores = StoreQModel::search_pending_stores_paging($search);
            $pagination = $stores->appends(array(
                'search-store' => Input::get('search-store')
            ));
            if(empty($stores[0])) {
                $request->session()->flash('alert-danger', 'Cửa hàng này không có trong danh sách các cửa hàng đã duyệt !');
                return back();
            } else {
                return view('vendor.adminlte.store.list_pending',compact('stores'));
            }
        }
        return back();
    }

    /**
     * Process approve a store
     *
     * @param $id int
     * @param Request $request
     * @return Response
     */
    public function approve_store($id, Request $request) {
        // Process pending store
        if (StoreCModel::update_store($id, ["status" => Constants::STORE_APPROVE])) {
            $request->session()->flash('alert-success', 'Cửa hàng vừa chọn đã được duyệt !');
            return back();
        }     
    }

    /**
     * Display list foods of a store by store_id
     *
     * @param $id int
     * @param $slug string
     * @param Request $request
     * @return Response
     */
    public function detail_store($slug, $id, Request $request) {
        // Get store
        $data['store'] = StoreQModel::get_store_by_id($id);
        // Get foods
        $data['foods'] = FoodQModel::get_foods_paging_by_store_id($id);
        return view('vendor.adminlte.store.detail', $data);
    }

    /**
     * Display interface create
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('vendor.adminlte.store.create');
    }

    /**
     * Store a store created in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Validate and store the stores...
        $this->validate($request, [
            'store-name' => 'required',
            'store-phone' => 'min:10|max:11',
            'store-open-time' => 'required',
            'store-close-time' => 'required',
            'store-address' => 'required',
            'store-email' => 'required',
            'store-logo' => 'image|mimes:jpeg,png,jpg,svg|required|max:3000',
        ]);

        // Check input slug
        if (empty($_POST['store-slug'])) {
            $slug = str_slug($_POST['store-name']);
        } else {
            $slug = str_slug($_POST['store-slug']);
        }

        // get input image logo
        $file = Input::file('store-logo');dd($file);

        // Create item to insert db
        $data = [
            'name' => $_POST['store-name'],
            'introduction' => $_POST['store-introdoction'],
            'status' => Constants::STORE_PENDING,
            'slug' => $slug,
            'address' => $_POST['store-address'],
            'phone' => $_POST['store-phone'],
            'sector' => $_POST['store-sector'],
            'open_time' => $_POST['store-open-time'],
            'close_time' => $_POST['store-close-time'],
            'email' => $_POST['store-email'],
            'facebook' => $_POST['store-facebook'],
            'logo' => ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['store']),
            'site_url' => '',
        ];

        // Process insert
        if (StoreCModel::insert_store($data)) {
            $request->session()->flash('alert-success', 'Cửa hàng đã được tạo thành công!');
            return back();
        } else {
            // delete image
            ImageHelper::delete_image($data->logo, Constants::MANAGE_IMAGE['store']);

            $request->session()->flash('alert-danger', 'Cửa hàng tạo không thành công!');
            return back();
        }
    }

    /**
     * Display interface update
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
         // Get stores
        $data['store'] = StoreQModel::get_store_by_id($id);
        if (!$data['store']) {
            return view('vendor.adminlte.errors.404');
        }

        return view('vendor.adminlte.store.edit', $data);
    }

    /**
     * Update a store in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // Check id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Cửa hàng cập nhật không thành công!');
            return back();
        }

        //Validate stores
        $this->validate($request, [
            'store-name' => 'required',
            'store-phone' => 'min:10|max:11',
            'store-address' => 'required',
            'store-email' => 'required',
            'store-logo' => 'image|mimes:jpeg,png,jpg,svg|max:3000',
        ]);

        // Get store
        $store = StoreQModel::get_store_by_id($id);

        // Check input slug
        if (empty($_POST['store-slug'])) {
            $slug = str_slug($_POST['store-name']);
        } else {
            $slug = str_slug($_POST['store-slug']);
        }

        // Create data_model to update to DB
        $data = [
            'name' => $_POST['store-name'],
            'introduction' => $_POST['store-introdoction'],
            'slug' => $slug,
            'address' => $_POST['store-address'],
            'phone' => $_POST['store-phone'],
            'sector' => $_POST['store-sector'],
            'open_time' => $_POST['store-open-time'],
            'close_time' => $_POST['store-close-time'],
            'email' => $_POST['store-email'],
            'facebook' => $_POST['store-facebook'],
        ];

        // Check update file
        if ($request->hasFile('store-logo')) {
            $file = Input::file('store-logo');
            $data['logo'] = ImageHelper::upload_image($file, Constants::MANAGE_IMAGE['store']);
        }

        // Process update store
        if (StoreCModel::update_store($id, $data)) {
            if (!empty($data['logo'])) {
                ImageHelper::delete_image($store->logo, Constants::MANAGE_IMAGE['store']);
            }

            $request->session()->flash('alert-success', 'Cửa hàng đã được cập nhật thành công!');
            return back();
        }

        return back();
    }

    /**
     * Delete a store.
     *
     * @param $id int
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request) {

        // Check input id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Cửa hàng xóa không thành công!');
            return back();
        }

        // Get store by id
        $store = StoreQModel::get_store_by_id($id);

        if (!$store) {
            return view('vendor.adminlte.errors.404');
        }

        // process delete store
        if (StoreCModel::delete_store($id)) {
            // Delete old image
            ImageHelper::delete_image($store->logo, Constants::MANAGE_IMAGE['store']);

            // Delete foods of store
            FoodCModel::delete_foods_by_store_id($id);

            // Delete store user
            StoreUserCModel::delete_store_user_by_store_id($id);

            $request->session()->flash('alert-success', 'Cửa hàng đã được xóa thành công!');
            return back();
        }
    }
}
