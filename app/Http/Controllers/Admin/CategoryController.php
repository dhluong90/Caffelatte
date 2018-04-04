<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\CategoryCModel;
use App\Http\Models\Dal\CategoryQModel;

/**
 * Class BlogController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Show list and search categories.
     *
     * @return Response
     */
    public function index(Request $request) {

        // Get all categories
        $categories = CategoryQModel::get_categories();
        return view('vendor.adminlte.category.list', compact('categories'));
    }

    /**
     * Show form create blog.
     *
     * @return Response
     */
    public function create() {
        $parent_categories = CategoryQModel::get_parent_categories();
        return view('vendor/adminlte/category/create', compact('parent_categories'));
    }

    /**
     * Store a new categories.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        // Validate and store the categories...
        $this->validate($request, [
            'category-name' => 'bail|required|min:5',
        ]);

        // Check input slug
        if (empty($_POST['category-slug'])) {
            $slug = str_slug($_POST['category-name']);
        } else {
            $slug = str_slug($_POST['category-slug']);
        }

        // Create item to insert db
        $data = [
            'name' => $_POST['category-name'],
            'description' => $_POST['category-description'],
            'parent_id' => $_POST['category-parent'],
            'slug' => $slug,
        ];

        // Process insert
        if (CategoryCModel::insert_category($data)) {
            $request->session()->flash('alert-success', 'Thể loại đã được tạo thành công!');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'Thể loại tạo không thành công!');
            return back();
        }
    }

    /**
     * Edit a category.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $categories = CategoryQModel::get_categories();
        //dd($categories);
        if (!$categories) {
            return view('vendor.adminlte.errors.404');
        }

        return view('vendor.adminlte.category.edit', compact('categories'));
    }

    /**
     * Update a category.
     *
     * @param int $id
     * @return Response
     */
    public function update($id, Request $request) {
        // Validate and store the blog...
        $this->validate($request, [
            'category-name' => 'required|min:3',
            'category-description' => 'required',
            'category-slug' => 'required'
        ]);

        // Check input slug
        if (empty($_POST['category-slug'])) {
            $slug = str_slug($_POST['category-name']);
        } else {
            $slug = str_slug($_POST['category-slug']);
        }

        // Create needed array to update to DB
        $data = [
            'name' => $_POST['category-name'],
            'description' => $_POST['category-description'],
            'parent_id' => $_POST['category_parent'],
            'slug' => $slug,
        ];

        // dd($data);

        // Check id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Thể loại cập nhật không thành công!');
            return back();
        }
        
        // Process update
        if (CategoryCModel::update_category($id, $data)) {
            $request->session()->flash('alert-success', 'Thể loại đã được cập nhật thành công!');
            return back();
        }else{

            $request->session()->flash('alert-danger', 'Thể loại cập nhật không thành công!');
            return back();
        }
    }

    /**
     * Delete a category.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request) {
        //dd($id);

        // Check id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Thể loại xóa không thành công !');
            return back();
        }

        // Get category by id 
        $category = CategoryQModel::get_category_by_id($id);
        if ($category->parent_id == 0) {
            $parent_id = $category->id;
            // Get child_category by parent_id
            $child_categories = CategoryQModel::get_child_categories_by_parent_id($parent_id);
            if (count($child_categories)) {
                foreach ($child_categories as $item) {
                    CategoryCModel::update_category($item->id, [
                        "parent_id" => 0
                    ]);
                }
            }

            // Process delete
            if (CategoryCModel::delete_category($id)) {
                $request->session()->flash('alert-success', 'Thể loại đã được xóa thành công !');
                return back();
            } 
        } else {
            $request->session()->flash('alert-success', 'Bạn không thể xóa thể loại con !');
                return back();
        }
    }
}