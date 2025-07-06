<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function edit()
    {
        $user = auth()->user();
        return view('user.users.edit', compact('user'));
    }
    public function update(Request $request)
{
    $user = Auth::user();

    // Validate
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        // 'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'gender' => 'required|in:male,female', // Đúng với select form của vợ
        'img' => 'nullable|image|max:2048',
    ]);

    // Cập nhật thông tin
    $user->name = $validated['name'];
    // $user->email = $validated['email'];
    $user->phone = $validated['phone'];
    $user->gender = $validated['gender'];

    // Nếu có file ảnh
    if ($request->hasFile('img')) {
        // Xoá ảnh cũ nếu tồn tại
        if ($user->img && Storage::disk('public')->exists($user->img)) {
            Storage::disk('public')->delete($user->img);
        }

        // Upload ảnh mới
        $user->img = $request->file('img')->store('img', 'public');
    }
    $user->save();

    // return redirect()->route('profile')->with('success', 'Cập nhật hồ sơ thành công!');
    return view('user.auth.profile', compact('user'));
}
}
