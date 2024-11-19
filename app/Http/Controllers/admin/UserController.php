<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->filter(request(['search']))->get();
        return view('dashboard.user.index',compact('users'));
    }
    public function show(User $user)
    {
        return view('dashboard.user.show', [
            'user' => $user,
        ]);
    }
    public function create()
    {
        return view('dashboard.user.create');
    }
    
    public function store(StoreUserRequest $request)
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
        User::create($validatedData);
        return redirect('/dashboard/admin/users')->with('success', 'Pengguna Berhasil Ditambahkan!');
    }
    
    public function edit(User $user)
    {
        return view('dashboard.user.edit',[
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        if($request->hasFile('image')){
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $randomFileName = hash('md5', time()) . '.' . $fileExtension;
            $request->file('image')->move('images/', $randomFileName);
        }
        if(isset($randomFileName)) {
            $validatedData['image'] = $randomFileName;
            $oldImagePath = public_path('images/') . $user->image;
            if(File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        $user->update($validatedData);
        return back()->with('success', 'Pengguna berhasil Diupdate!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','Pengguna Berhasil Dihapus!');
    }
}
