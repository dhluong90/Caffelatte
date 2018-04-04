<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\BlogCModel;
use App\Http\Models\Dal\BlogQModel;

/**
 * Class ToolController
 * @package App\Http\Controllers\Api
 */
class ToolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index() {

    }

    public function get_blogs(Request $request) {
        $blogs = BlogQModel::get_blogs_paging();
        return json_encode($blogs);
    }

    public function get_blog($id, Request $request) {
        return $id;
    }

    public function create_blog(Request $request) {
        return response(json_encode([
                'token' => $request->header('token'),
                'blog_name' => $request->name, 
                'blog_description' => $request->description
            ]), 403)->header('Content-Type', 'application/json');
    }

    public function update_blog($id, Request $request) {
        return json_encode([
            'token' => $request->header('token'),
            'id' => $id,
            'blog_name' => $request->name, 
            'blog_description' => $request->description
        ]);
    }

    public function delete_blog($id, Request $request) {
        return json_encode([
            'token' => $request->header('token'),
            'blog_id' => $id
        ]);
    }
}