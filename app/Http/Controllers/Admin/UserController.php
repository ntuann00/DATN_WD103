<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Users;
use App\Models\Category;
use Illuminate\Http\Request;
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
    $urlImg = null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Lưu vào storage/app/public/avatar
            $file->storeAs('public/img', $filename);

            // Đường dẫn lưu trong database: public/storage/avatar/filename
            $urlImg = 'img/' . $filename;
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
         $roles = Role::all(); // để đổ select box role_name
    return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id) {
              
    }
}
