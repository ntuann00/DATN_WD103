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

class UserController extends BaseController
{

    public function index()
    {
       $users = Users::all();
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

    public function show($id)
    {

    
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
         $roles = Role::all();
        return view('admin.users.edit', compact('users', 'roles'));
    }


public function update(Request $request, User $user, $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'birthday' => 'nullable|date',
            'gender'   => 'nullable|in:male,female',
            'role_id'  => 'required|integer|exists:roles,id',
            'status'   => 'required|boolean',
            'img'      => 'nullable|image|max:2048',
        ]);

       if ($request->hasFile('image')) {
            $img = $request->file('uploads');
            $imgName = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $imgName);
            $validatedData['img'] = $imgName;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

  public function destroy($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Đã xoá người dùng');
    }
}
