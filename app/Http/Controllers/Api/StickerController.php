<?php
namespace app\Http\Controllers\Api;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StickerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function list_sticker(Request $request) {
        $directories = File::directories('uploads/sticker');
        $data = [];
        foreach ($directories as $directory) {
            $name = mb_substr($directory, mb_strrpos($directory, '/') + 1);
            $files = File::files($directory);
            $temp = [
                'name' => $name,
                'items' => []
            ];
            foreach ($files as $file) {
                array_push($temp['items'], url('/') . '/' . $file);
            }
            array_push($data, $temp);
        }
        return ApiHelper::success($data);
    }
}