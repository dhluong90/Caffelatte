<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\FoodCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\CategoryQModel;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Dal\TagCModel;
use App\Http\Models\Dal\FoodTagQModel;
use App\Http\Models\Dal\FoodTagCModel;
use App\Http\Models\Dal\FoodCommentQModel;
use App\Http\Models\Dal\FoodCommentCModel;
use App\Http\Models\Business\FoodModel;
use App\Http\Helpers\Constants;
use App\Http\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class FoodController extends Controller 
{
    /**
     * list food
     * @param $page, $limit
     * @return object data about items, pagination
     */
    public function list(Request $request) {
        $limit = empty($request->limit) ? Constants::API_LIMIT_ITEMS : $request->limit;
        $page = empty($request->page) ? Constants::API_DEFAULT_PAGE  : $request->page;
        $offset = ($page - 1) * $limit;

        $data['items'] = FoodQModel::get_foods($offset, $limit);

        $pagination['total_items'] = FoodQModel::count_foods();
        $pagination['current_page'] = $page;
        $pagination['limit_item'] = $limit;

        $data['pagination'] = $pagination;

        return ApiHelper::success((object)$data, 200);
    }

    /**
     * detail food
     * @param $id
     * @return object data
     */
    public function detail(Request $request, $id) {
        $data = FoodQModel::get_food_by_id($id);
        return ApiHelper::success((object)$data, 200);
    }
}