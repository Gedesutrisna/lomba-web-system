<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\faq;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->take(3)->get();
    
        return view('home', compact('blogs'));
    }        

}
