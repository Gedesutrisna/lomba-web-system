<?php

namespace App\Http\Controllers\admin;

use App\Models\Instructor;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreInstructorRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateInstructorRequest;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::latest()->filter(request(['search']))->get();
        return view('dashboard.instructor.index',compact('instructors'));
    }
    public function show(Instructor $instructor)
    {
        return view('dashboard.instructor.show', [
            'instructor' => $instructor,
        ]);
    }
    public function create()
    {
        return view('dashboard.instructor.create');
    }
    
    public function store(StoreInstructorRequest $request)
    {
        $validatedData = $request->validated();
        if($request->hasFile('image')){
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $randomFileName = hash('md5', time()) . '.' . $fileExtension;
            $request->file('image')->move('images/', $randomFileName);
        }
        if(isset($randomFileName)) {
            $validatedData['image'] = $randomFileName;
        }
        Instructor::create($validatedData);
        return redirect('/dashboard/admin/instructors')->with('success', 'Pengguna Berhasil Ditambahkan!');
    }
    
    public function edit(Instructor $instructor)
    {
        return view('dashboard.instructor.edit',[
            'instructor' => $instructor,
        ]);
    }

    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $validatedData = $request->validated();
        if($request->hasFile('image')){
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $randomFileName = hash('md5', time()) . '.' . $fileExtension;
            $request->file('image')->move('images/', $randomFileName);
        }
        if(isset($randomFileName)) {
            $validatedData['image'] = $randomFileName;
            $oldImagePath = public_path('images/') . $instructor->image;
            if(File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        $instructor->update($validatedData);
        return back()->with('success', 'Pengguna berhasil Diupdate!');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return back()->with('success','Pengguna Berhasil Dihapus!');
    }
}
