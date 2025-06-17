<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Users;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{

    public function index()
    {
       $users = Users::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all(); // lấy danh sách role
        return view('admin.users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'birthday' => 'nullable|date',
            'gender'   => 'nullable|in:male,female',
            'role_id'  => 'required|integer|exists:roles,id',
            'status'   => 'required|boolean',
            'img'      => 'nullable|image|max:2048',
        ]);

        // Xử lý upload ảnh nếu có

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $validated['img'] = $file->store('images', 'public');
        }

        // Mã hoá mật khẩu
        $validated['password'] = bcrypt($validated['password']);

        // Tạo user mới
        Users::create($validated);

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công!');
    }

    public function show($id) {
         $users = Users::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', compact('users', 'roles'));
    }

    public function edit($id)
    {
        $users = Users::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('users', 'roles'));
    }



    public function update(Request $request, Users $users)
    {
         $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($users->id)],
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'birthday' => 'nullable|date',
            'gender'   => 'nullable|in:male,female',
            'role_id'  => 'required|integer|exists:roles,id',
            'status'   => 'required|boolean',
            'img'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            if ($users->img && Storage::disk('public')->exists($users->img)) {
                Storage::disk('public')->delete($users->img);
            }
            $validated['img'] = $request->file('img')->store('img', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $users->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Đã xoá người dùng');
    }
}
