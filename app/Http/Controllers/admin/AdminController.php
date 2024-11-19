<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.profile.index');
    }
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validatedData = $request->validated();
        if ($request->filled('password') && $validatedData['password'] !== $request->input('password_confirmation')) {
            return back()->with('toast_error', 'Password harus sama dengan Konfirmasi Password!');
        }
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        if($request->hasFile('image')){
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $randomFileName = hash('md5', time()) . '.' . $fileExtension;
            $request->file('image')->move('images/', $randomFileName);
        }
        if(isset($randomFileName)) {
            $validatedData['image'] = $randomFileName;
            $oldImagePath = public_path('images/') . auth()->guard('admin')->user()->image;
            if(File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        auth()->guard('admin')->user()->update($validatedData);
        return back()->with('toast_success', 'Profile berhasil diperbaharui!');
    }
}
