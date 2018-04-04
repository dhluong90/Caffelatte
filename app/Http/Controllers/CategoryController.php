<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\TagQModel;
use App\Http\Models\Dal\FoodQModel;
use App\Http\Models\Dal\CategoryQModel;
use App\Http\Models\Business\FoodModel;

class CategoryController extends PageController 
{
    /**
     * filer food by slug category in page home.
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function detail($category_slug) {
        $category_for_slug = CategoryQModel::get_category_by_slug($category_slug);
        if (empty($category_for_slug)) {
            return view('vendor.adminlte.errors.404');
        }
        $foods_object = FoodQModel::get_foods_by_category_slug($category_slug);
        $data['tags_show'] = TagQModel::get_all_tags();
        $data['view_all_tag'] = true;
        $arr_tag = [];
        $data['foods_tag'] = TagQModel::get_all_tags_except_array_tag($arr_tag);
        $data['category_slug'] = $category_slug;

        $data['foods'] = [];
        foreach ($foods_object as $food) {
            $food->type = 'food';
            $data['foods'][] = $food;
        }
        
        if (Auth::id() != null) {
            $data['foods_like_id'] = FoodModel::get_foods_like_id_by_user_id(Auth::id());
        }

        return view('pages.category.detail', $data);

    }
}