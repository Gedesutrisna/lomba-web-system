<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('dashboard.admin.category.index',compact('categories'));
    }
    public function show(Category $category)
    {
        return view('dashboard.admin.category.show', [
            'category' => $category,
        ]);
    }
    public function create()
    {
        return view('dashboard.admin.category.create');
    }
    public function edit(Category $category)
    {
        return view('dashboard.admin.category.edit',[
            'category' => $category,
        ]);
    }
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        Category::create($validatedData);
        return redirect('/dashboard/admin/categories')->with('success','Category Created Successfully!');
    }
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category->update($validatedData);
        return redirect('/dashboard/admin/categories')->with('success','Category Updated Successfully!');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category Deleted Successfully!');
    }
}
