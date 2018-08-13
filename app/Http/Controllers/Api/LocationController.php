<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\CityQModel;
use App\Http\Models\Dal\CountryQModel;
use Illuminate\Http\Request;

class LocationController extends Controller
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

    public function getListCountry(Request $request) {
        $listCountry = CountryQModel::all();
        return ApiHelper::success($listCountry);
    }

    public function getListCityByCountryCode(Request $request, $code) {
        $listCity = CityQModel::where('country_code', $code)->get();
        return ApiHelper::success($listCity);
    }

    //
}
