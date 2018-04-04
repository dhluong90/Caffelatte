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
use App\Http\Models\Dal\BlogCModel;
use App\Http\Models\Dal\BlogQModel;
use App\Http\Helpers\Constants;
use App\Http\Helpers\ImageHelper;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Input;

/**
 * Class BlogController
 * @package App\Http\Controllers\Admin
 */
class BlogController extends Controller
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
     * Show list blogs.
     *
     * @return Response
     */
    public function index() {
        //Get Blogs
        $blogs = BlogQModel::get_blogs_paging();
        return view('vendor.adminlte.blog.list', compact('blogs'));
    }

    /**
     * Show form create blog.
     *
     * @return Response
     */
    public function create() {
        return view('vendor/adminlte/blog/create');
    }

    /**
     * Store a new blog.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        // Validate and store the blog...
        $this->validate($request, [
            'blog-name' => 'bail|required|min:3',
            'blog-image' => 'image|mimes:jpeg,png,jpg,svg|required|max:3000',//Support dimension
            'blog-content' => 'required|min:20'
        ]);

        // Process upload image
        // Check file
        if (!$request->hasFile('blog-image')) {
            $request->session()->flash('alert-danger', 'Bài viết tạo không thành công!');
            return back();
        }

        $file = Input::file('blog-image');
        $blog_image_name = ImageHelper::convert_image_name($file->getClientOriginalName());

        // Create item to insert db
        $blog = [
            'user_id' => Auth::id(),
            'name' => $_POST['blog-name'],
            'content' => $_POST['blog-content'],
            'image' => Constants::URL_IMAGE_BLOG . $blog_image_name
        ];
        
        if (BlogCModel::insert_blog($blog)) {
            //Move file to server
            ImageHelper::upload_image($file, $blog_image_name, Constants::URL_IMAGE_BLOG);
            $request->session()->flash('alert-success', 'Bài viết đã được tạo thành công!');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'Bài viết tạo không thành công!');
            return back();
        }
    }

    /**
     * Edit a blog blog.
     *
     * @param blog_id
     * @return Response
     */
    public function edit($blog_id) {
        // Get blog
        $blog = BlogQModel::get_blog_by_id($blog_id);

        if (!$blog) {
            return view('vendor.adminlte.errors.404');
        }

        return view('vendor.adminlte.blog.edit', compact('blog'));
    }

    /**
     * Update a blog.
     *
     * @param blog_id
     * @return Response
     */
    public function update($blog_id, Request $request) {

        // Validate and store the blog...
        $this->validate($request, [
            'blog-name' => 'required|min:3',
            'blog-image' => 'image|mimes:jpeg,png,jpg,svg|max:3000',//Support dimension
            'blog-content' => 'required|min:20'
        ]);
        
        // Get blog
        $blog = BlogQModel::get_blog_by_id($blog_id);

        // check blog == FALSE
        if (!$blog) {
            $request->session()->flash('alert-danger', 'Bài viết cập nhật không thành công!');
            return back();
        }

        // Create data_model to update to DB
        $data_model = [
            'name' => $_POST['blog-name'],
            'content' => $_POST['blog-content']
        ];

        // Process upload image
        $image_uploaded = FALSE;

        // Check file
        if ($request->hasFile('blog-image')) {
            $image_uploaded = TRUE;
            $file = Input::file('blog-image');
            $new_blog_image_name = ImageHelper::convert_image_name($file->getClientOriginalName());

            // add new image url to data_model
            $data_model['image'] = Constants::URL_IMAGE_BLOG . $new_blog_image_name;
        }
        
        // Update data
        if (BlogCModel::update_blog($blog_id, $data_model)) {
            if ($image_uploaded == TRUE) {
                //upload new image
                ImageHelper::upload_image($file, $new_blog_image_name, Constants::URL_IMAGE_BLOG);
                //delete old image
                ImageHelper::delete_image($blog->image);
            }

            $request->session()->flash('alert-success', 'Bài viết đã được cập nhật thành công!');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'Bài viết cập nhật không thành công!');
            return back();
        }
    }

    /**
     * Delete a blog.
     *
     * @param blog_id
     * @param Request $request
     * @return Response
     */
    public function delete($blog_id, Request $request) {
        // Get blog
        $blog = BlogQModel::get_blog_by_id($blog_id);
        // check blog = FALSE
        if (!$blog) {
            $request->session()->flash('alert-danger', 'Bài viết xóa không thành công!');
            return back();
        }

        $old_image_url = $blog->image;
        if (BlogCModel::delete_blog($blog_id)) {
            //delete old image.
            ImageHelper::delete_image($old_image_url);

            $request->session()->flash('alert-success', 'Bài viết đã được xóa thành công!');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'Bài viết xóa không thành công!');
            return back();
        }    
    }
}