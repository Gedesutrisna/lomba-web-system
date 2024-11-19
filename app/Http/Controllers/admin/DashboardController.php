<?php

namespace App\Http\Controllers\admin;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Portfolio;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index(){
        $blogs = Blog::latest()->get();
        return view('dashboard.index',compact( 'blogs'));
    }
    
}
