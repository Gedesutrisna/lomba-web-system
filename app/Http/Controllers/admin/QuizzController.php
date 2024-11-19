<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Quizz;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizzRequest;
use App\Http\Requests\UpdateQuizzRequest;

class QuizzController extends Controller
{
    public function index()
    {
        $quizzes = Quizz::latest()->get();
        return view('dashboard.admin.quizz.index',compact('quizzes'));
    }
    public function show(Quizz $quizz)
    {
        return view('dashboard.admin.quizz.show', [
            'quizz' => $quizz,
        ]);
    }
    public function create()
    {
        return view('dashboard.admin.quizz.create');
    }
    public function edit(Quizz $quizz)
    {
        return view('dashboard.admin.quizz.edit',[
            'quizz' => $quizz,
        ]);
    }
    public function store(StoreQuizzRequest $request)
    {
        $validatedData = $request->validated();
        Quizz::create($validatedData);
        return redirect('/dashboard/admin/quizzes')->with('success','Quizz Created Successfully!');
    }
    public function update(UpdateQuizzRequest $request, Quizz $quizz)
    {
        $validatedData = $request->validated();
        $quizz->update($validatedData);
        return redirect('/dashboard/admin/quizzes')->with('success','Quizz Updated Successfully!');
    }
    public function destroy(Quizz $quizz)
    {
        $quizz->delete();
        return back()->with('success', 'Quizz Deleted Successfully!');
    }
}
