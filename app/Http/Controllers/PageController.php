<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\CategoryQModel;
use View;

class PageController extends Controller 
{
    public function __construct() {
        // do some thing ...
        parent::__construct();

        // set global variable
        $this->middleware(function(Request $request, $next) {
            // set $can_manage
            $can_mange = FALSE;

            if (Auth::check()) {
                if (UserModel::check_manager(Auth::id())) {
                    $can_mange = TRUE;
                }
            }
            
            View::share('can_mange', $can_mange);
            return $next($request);
        });

        //Fetch data categories for menu
        // Get all categories
        $categories_menu = CategoryQModel::get_categories();
        View::share('categories_menu', $categories_menu);
    }    
}