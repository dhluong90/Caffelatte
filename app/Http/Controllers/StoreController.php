<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use App\Http\Models\Dal\StoreQModel;
use App\Http\Models\Dal\StoreCModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Dal\StoreCommentQModel;
use App\Http\Models\Bussiness\UserModel;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\Constants;
use App\Http\Helpers\ImageHelper;

class StoreController extends PageController 
{
    /**
    * Display store detail
    *
    * Response array data 
    */
    public function detail($store_slug, $store_id, Request $request) {
        // Get store by store_id
        $data['store'] = StoreQModel::get_store_by_store_id($store_id);
        $data['store']->branch = json_decode($data['store']->branch, true);
        if (!$data['store'] || !is_numeric($store_id)) {
            return view('vendor.adminlte.errors.404');
        }
        // Get tags by store_id
        $data['tags_by_store'] = TagQModel::get_tags_by_store_id($store_id);
        // Check isset tag_slug
        if (isset($_GET['tag_slug'])) {

            if ($_GET['tag_slug'] == '') {
                $data['foods'] = FoodQModel::get_foods_paging_by_store_id($store_id);
            } else {
                $arrTag = explode(" ", $_GET["tag_slug"]);
                // Get foods of store by tag_slug, $store_id
                $data['foods'] = FoodQModel::get_foods_of_store_paging_by_tag_slug($arrTag, $store_id);
                $rename_tag_slug = str_replace(' ', '+', $_GET['tag_slug']);
                $data['foods']->withPath('/'.$request->path().'/?tag_slug='.$rename_tag_slug);
            }
        } else {
            // Get foods by store_id
            $data['foods'] = FoodQModel::get_foods_paging_by_store_id($store_id);
        }

        // map
        $data['map'] = FALSE;

        // Get JSON results from this request
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($data['store']->address).'&sensor=false');
        // Convert the JSON to an array
        $geo = json_decode($geo, true);

        if ($geo['status'] == 'OK') {
            $data['map'] = TRUE;

            // Get Lat & Long
            $latitude = $geo['results'][0]['geometry']['location']['lat'];
            $longitude = $geo['results'][0]['geometry']['location']['lng'];

            Mapper::location($data['store']->address)->map(['zoom' => 16, 'center' => true, 'marker' => true, 'draggable' => true]);
        }

        //get comments
        $data['comments'] = StoreCommentQModel::get_store_comments_by_store_id($store_id);

        if (Auth::id() != null) {
            $data['foods_like'] = FoodQModel::get_like_foods_by_user_id(Auth::id());
        }

        return view('pages.store.detail', $data);
    }
}