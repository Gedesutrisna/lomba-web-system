<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::latest()->get();
        return view('dashboard.admin.lesson.index',compact('lessons'));
    }
    public function show(Lesson $lesson)
    {
        return view('dashboard.admin.lesson.show', [
            'lesson' => $lesson,
        ]);
    }
    public function create()
    {
        return view('dashboard.admin.lesson.create');
    }
    public function edit(Lesson $lesson)
    {
        return view('dashboard.admin.lesson.edit',[
            'lesson' => $lesson,
        ]);
    }
    public function store(StoreLessonRequest $request)
    {
        $validatedData = $request->validated();
        Lesson::create($validatedData);
        return redirect('/dashboard/admin/lessons')->with('success','Lesson Created Successfully!');
    }
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $validatedData = $request->validated();
        $lesson->update($validatedData);
        return redirect('/dashboard/admin/lessons')->with('success','Lesson Updated Successfully!');
    }
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson Deleted Successfully!');
    }
}
