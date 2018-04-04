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
use App\Http\Models\Dal\TagCModel;
use App\Http\Models\Dal\TagQModel;

/**
 * Class TagController
 * @package App\Http\Controllers\Admin
 */
class TagController extends Controller
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
     * Show list and search tags.
     *
     * @return Response
     */
    public function index(Request $request) {

        $tags = TagQModel::get_all_tags();
        return view('vendor.adminlte.tag.list', compact('tags')); 
}

    /**
     * Show form create tag.
     *
     * @return Response
     */
    public function create() {
        return view('vendor/adminlte/tag/create');
    }

    /**
     * Store a new tags.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        // Validate and store the tags...
        $this->validate($request, [
            'tag-name' => 'bail|required|min:5',
        ]);

        // Check input slug 
        if (empty($_POST['tag-slug'])) {
            $slug = str_slug($_POST['tag-name']);
        } else {
            $slug = str_slug($_POST['tag-slug']);
        }

        // Create item to insert db
        $data = [
            'name' => $_POST['tag-name'],
            'slug' => $slug,
        ];

        // Process insert
        if (TagCModel::insert_tag($data)) {
            $request->session()->flash('alert-success', 'Nhãn đã được tạo thành công!');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'Nhãn tạo không thành công!');
            return back();
        }
    }

    /**
     * Edit a tag.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        // Get tags
        $tag = TagQModel::get_tag_by_id($id);
        if (!$tag) {
            return view('vendor.adminlte.errors.404');
        }

        return view('vendor.adminlte.tag.edit', compact('tag'));
    }

    /**
     * Update a tag.
     *
     * @param int $id
     * @return Response
     */
    public function update($id, Request $request) {
        // Validate and store the tag...
        $this->validate($request, [
            'tag-name' => 'required|min:3',
        ]);

        // Check input slug 
        if (empty($_POST['tag-slug'])) {
            $slug = str_slug($_POST['tag-name']);
        } else {
            $slug = str_slug($_POST['tag-slug']);
        }

        // Create needed array to update to DB
        $data = [
            'name' => $_POST['tag-name'],
            'slug' => $slug,
        ];

        // Check id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Nhãn cập nhật không thành công!');
            return back();
        }

        // Process update
        if (TagCModel::update_tag($id, $data)) {
            $request->session()->flash('alert-success', 'Nhãn đã được cập nhật thành công!');
            return back();
        }
        return back();
    }

    /**
     * Delete a tag.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request) {

        // Check id error
        if (!$id  || !is_numeric($id)) {
            $request->session()->flash('alert-danger', 'Nhãn xóa không thành công!');
            return back();
        }

        // Process delete
        if (TagCModel::delete_tag($id)) {
            $request->session()->flash('alert-success', 'Nhãn đã được xóa thành công!');
            return back();
        }
    }
}