<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->get();
        return view('dashboard.admin.question.index',compact('questions'));
    }
    public function show(Question $question)
    {
        return view('dashboard.admin.question.show', [
            'question' => $question,
        ]);
    }
    public function create()
    {
        return view('dashboard.admin.question.create');
    }
    public function edit(Question $question)
    {
        return view('dashboard.admin.question.edit',[
            'question' => $question,
        ]);
    }
    public function store(StoreQuestionRequest $request)
    {
        $validatedData = $request->validated();
        Question::create($validatedData);
        return redirect('/dashboard/admin/questions')->with('success','Question Created Successfully!');
    }
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $validatedData = $request->validated();
        $question->update($validatedData);
        return redirect('/dashboard/admin/questions')->with('success','Question Updated Successfully!');
    }
    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Question Deleted Successfully!');
    }
}
