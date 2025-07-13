<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
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

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('images', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'birthday' => 'nullable|date',
            'gender'   => 'nullable|in:male,female',
            'role_id'  => 'required|integer|exists:roles,id',
            'status'   => 'required|boolean',
            'img'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            if ($user->img && Storage::disk('public')->exists($user->img)) {
                Storage::disk('public')->delete($user->img);
            }
            $validated['img'] = $request->file('img')->store('images', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role && $user->role->name === 'admin') {
            return redirect()->route('users.index')->with('error', 'Không thể khóa tài khoản quản trị viên.');
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Đã cập nhật trạng thái tài khoản.');
    }
}
