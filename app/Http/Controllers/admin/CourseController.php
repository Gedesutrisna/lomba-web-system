<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('dashboard.admin.course.index',compact('courses'));
    }
    public function show(Course $course)
    {
        return view('dashboard.admin.course.show', [
            'course' => $course,
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.admin.course.create',compact('categories'));
    }
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('dashboard.admin.course.edit',compact('categories'),[
            'course' => $course,
        ]);
    }
    public function store(StoreCourseRequest $request)
    {
        $validatedData = $request->validated();
        Course::create($validatedData);
        return redirect('/dashboard/admin/courses')->with('success','Course Created Successfully!');
    }
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validatedData = $request->validated();
        $course->update($validatedData);
        return redirect('/dashboard/admin/courses')->with('success','Course Updated Successfully!');
    }
    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course Deleted Successfully!');
    }
}
