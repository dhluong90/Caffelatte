<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\FoodCModel;
use App\Http\Models\Dal\StoreQModel;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;
use Illuminate\Routing\UrlGenerator;


class FoodController extends Controller
{
     /**
     * Show list approved foods
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get foods
        $foods = FoodQModel::get_approved_foods_paging();
        return view('vendor.adminlte.food.list', compact('foods'));
    }

    /**
     * Search approved foods
     *
     * @param string $search
     * @param Request $request
     * @return Response
     */
    public function search_list_approved_foods(Request $request) {
        $search = Input::get('search-food');
        if (!empty($search)) {
            $foods = FoodQModel::search_approved_foods_paging($search);
            $pagination = $foods->appends(array(
                'search-food' => Input::get('search-food')
            ));
            if(empty($foods[0])) {
                $request->session()->flash('alert-danger', 'Món ăn này không có trong danh sách các món ăn đã duyệt!');
                return back();
            } else {
                return view('vendor.adminlte.food.list',compact('foods'));
            }
        }
        return back();
    }

    /**
     * Show list pending foods.
     *
     *
     * @param Request $request
     * @return Response
     */
    public function list_pending_foods(Request $request) {
        // Get foods
        $foods = FoodQModel::get_pending_foods_paging();
        return view('vendor.adminlte.food.list_pending',compact('foods'));
    }

    /**
     * Search pending foods
     *
     * @param string $search
     * @param Request $request
     * @return Response
     */
    public function search_list_pending_foods(Request $request) {
        
        $search = Input::get('search-food');
        if (!empty($search)) {
            $foods = FoodQModel::search_pending_foods_paging($search);
            $pagination = $foods->appends(array(
                'search-food' => Input::get('search-food')
            ));
            if(empty($foods[0])) {
                $request->session()->flash('alert-danger', 'Món ăn này không có trong danh sách các món ăn chờ duyệt!');
                return back();
            } else {
                return view('vendor.adminlte.food.list_pending',compact('foods'));
            }
        }
        return back();
    }

    /**
     * Show food detail by id
     *
     * @param $id int
     * @param $slug string
     * @param Request $request
     * @return Response
     */
    public function detail_food($slug, $id, Request $request) {// NOTEEEEEEEEEEEEE WHY $slug?!
        // Get constant
        $data['constants'] = new Constants;
        // Get food
        $data['food'] = FoodQModel::get_food_by_id($id);
        return view('vendor.adminlte.food.detail_food', compact('data'));
    }

    /**
     * Process approve a food
     *
     * @param $id int
     * @param Request $request
     * @return Response
     */
    public function approve_food($id, Request $request) {
        // Process pending store
        if (FoodCModel::update_food($id, ["status" => Constants::FOOD_APPROVE])) {
            $request->session()->flash('alert-success', 'Món ăn vừa chọn đã được duyệt!');
            return back();
        }     
    }

    /**
     * Delete a food.
     *
     * @param $id int
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request) {

        // Check input id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Món ăn xóa không thành công!');
            return back();
        }

        // Get food by id
        $food = FoodQModel::get_food_by_id($id);
        if ($food == true) {
            // process delete food
            if (FoodCModel::delete_food($id)) {
                //delete old image.
                ImageHelper::delete_image($food->images, Constants::MANAGE_IMAGE['food']);

                $request->session()->flash('alert-success', 'Món ăn đã được xóa thành công!');
                return back();
            } 
        } else {
            return view('pages.error.404');
        }
    }
}
