<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
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
use App\Http\Helpers\ImageHelper;
use App\Http\Helpers\Constants;

class FoodController extends PageController 
{
    /**
     * filer food by slug tag in page home.
     * @param
     * @return \Illuminate\Http\Response
     */
    public function list_food() {
        if (isset($_GET['tag'])) {
            $arrTag = explode(" ", $_GET["tag"]);

            if ($_GET["tag"] == null) {
                $foods_object = FoodQModel::get_foods_by_name_food('');
                $data['tags_show'] = TagQModel::get_all_tags();
                $data['view_all_tag'] = true;
            } else {
                $foods_object = FoodQModel::get_food_by_tag_slug($arrTag);
                $data['tags_show'] = TagQModel::get_tag_by_slug($arrTag);
                $data['view_all_tag'] = false;
            }
            $data['foods_tag'] = TagQModel::get_all_tags_except_array_tag($arrTag);
        } else {
            $foods_object = FoodQModel::get_foods_by_name_food('');
            $data['tags_show'] = TagQModel::get_all_tags();
            $data['view_all_tag'] = true;
        }
        
        $data['foods'] = [];
        foreach ($foods_object as $food) {
            $food->type = 'food';
            $data['foods'][] = $food;
        }

        if (Auth::id() != null) {
            $data['foods_like_id'] = FoodModel::get_foods_like_id_by_user_id(Auth::id());
        }
        
        return view('pages.food.list', $data);
    }

    /**
     * Food detail
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $food_slug, $food_id) {
        $data['food'] = FoodQModel::get_food_by_id($food_id);
        if (!$data['food'] || !is_numeric($food_id)) {
            // 404
            return view('vendor.adminlte.errors.404');
        }

        $data['store'] = StoreQModel::get_store_by_id($data['food']->store_id);
        $data['foods_slider'] = FoodQModel::get_foods_by_store($food_id, $data['food']->store_id);

        // get array tag_id of food
        $food_tags = TagQModel::get_tags_by_food_id($food_id);
        $tags_id = [];
        foreach ($food_tags as $tag) {
               array_push($tags_id, $tag->id);
        }
        $data['foods_like_tag'] = FoodQModel::get_foods_different_store_by_tag($food_id, $data['food']->store_id, $tags_id);
        $data['tags'] = TagQModel::get_tags_by_food_id($food_id);
        $data['guides'] = !empty($data['food']->guides) ? json_decode($data['food']->guides) : [];
        $data['steps'] = !empty($data['food']->steps) ? json_decode($data['food']->steps) : [];

        //get comment
        $data['comments'] = FoodCommentQModel::get_food_comments_by_food_id($food_id);

        if (Auth::id() != null) {
            $data['foods_like'] = FoodQModel::get_like_foods_by_user_id(Auth::id());
        }

        return view('pages.food.detail', $data);
    }
}

