<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('dashboard.admin.blog.index',compact('blogs'));
    }
    public function show(Blog $blog)
    {
        return view('dashboard.admin.blog.show', [
            'blog' => $blog,
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.admin.blog.create',compact('categories'));
    }
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('dashboard.admin.blog.edit',compact('categories'),[
            'blog' => $blog,
        ]);
    }
    public function store(StoreBlogRequest $request)
    {
        $validatedData = $request->validated();
        Blog::create($validatedData);
        return redirect('/dashboard/admin/blogs')->with('success','Blog Created Successfully!');
    }
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $validatedData = $request->validated();
        $blog->update($validatedData);
        return redirect('/dashboard/admin/blogs')->with('success','Blog Updated Successfully!');
    }
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog Deleted Successfully!');
    }
}
