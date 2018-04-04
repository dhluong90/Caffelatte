<?php

namespace App\Http\Controllers\Partial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Constants;
use App\Http\Helpers\YoutubeHelper;

class FoodController extends Controller
{
    /**
     * Get html show video of food
     *
     * @return \Illuminate\Http\Response
     */
    public function get_video() {
        if (!isset($_GET['videos'])) {
            return '';
        }

        // convert string $_GET['videos'] to array
        $videos = json_decode($_GET['videos']);

        $data['videos'] = YoutubeHelper::get_info_video_by_id($videos);

        return view('pages.food.partials.video', $data);
    }

}
