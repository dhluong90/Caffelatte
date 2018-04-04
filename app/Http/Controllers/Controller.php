<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;
use App\Http\Helpers\TimeHelper;
use App\Http\Helpers\YoutubeHelper;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        View::share('ImageHelper', new ImageHelper);
        View::share('Constants', new Constants);
        View::share('TimeHelper', new TimeHelper);
        View::share('YoutubeHelper', new YoutubeHelper);
    }
}
