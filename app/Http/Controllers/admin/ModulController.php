<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Modul;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModulRequest;
use App\Http\Requests\UpdateModulRequest;

class ModulController extends Controller
{
    public function index()
    {
        $moduls = Modul::latest()->get();
        return view('dashboard.admin.modul.index',compact('moduls'));
    }
    public function show(Modul $modul)
    {
        return view('dashboard.admin.modul.show', [
            'modul' => $modul,
        ]);
    }
    public function create()
    {
        return view('dashboard.admin.modul.create');
    }
    public function edit(Modul $modul)
    {
        return view('dashboard.admin.modul.edit',[
            'modul' => $modul,
        ]);
    }
    public function store(StoreModulRequest $request)
    {
        $validatedData = $request->validated();
        Modul::create($validatedData);
        return redirect('/dashboard/admin/moduls')->with('success','Modul Created Successfully!');
    }
    public function update(UpdateModulRequest $request, Modul $modul)
    {
        $validatedData = $request->validated();
        $modul->update($validatedData);
        return redirect('/dashboard/admin/moduls')->with('success','Modul Updated Successfully!');
    }
    public function destroy(Modul $modul)
    {
        $modul->delete();
        return back()->with('success', 'Modul Deleted Successfully!');
    }
}
