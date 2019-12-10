<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getInterests(Request $request) {
        $lang = $request->query('lang', 'vi');
        if (!in_array($lang, array("vi", "en"))) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'), 400,
                "Language doesn't support. Only support vi, en",
                400
            );
        }
        $interests = config('interests')[$lang];
        $response = [];
        foreach ($interests as $key => $value) {
            array_push($response, [
                "key" => $key,
                "value" => $value
            ]);
        }
            
        return ApiHelper::success($response);
    }
}
