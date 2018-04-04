<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\CategoryQModel;
use App\Http\Models\Dal\StoreCommentQModel;
use App\Http\Models\Dal\StoreCommentCModel;
use App\Http\Models\Business\StoreModel;
use App\Http\Helpers\Constants;
use App\Http\Helpers\ApiHelper;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    /**
     * list Store
     * @param $page, $limit
     * @return object data about items, pagination
     */
    public function list(Request $request) {
        $limit = empty($request->limit) ? Constants::API_LIMIT_ITEMS : $request->limit;
        $page = empty($request->page) ? Constants::API_DEFAULT_PAGE  : $request->page;
        $offset = ($page - 1) * $limit;

        $data['items'] = StoreQModel::get_stores($offset, $limit);

        $pagination['total_items'] = StoreQModel::count_stores();
        $pagination['current_page'] = $page;
        $pagination['limit_item'] = $limit;

        $data['pagination'] = $pagination;

        return ApiHelper::success((object)$data, 200);
    }

    /**
     * detail Store
     * @param $id
     * @return object data
     */
    public function detail(Request $request, $id) {
        $data = StoreQModel::get_store_by_id($id);
        return ApiHelper::success((object)$data, 200);
    }
}