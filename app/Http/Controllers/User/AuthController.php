<?php

namespace App\Http\Controllers\User;

use App\Models\Users;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function showRegisterForm()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'gender'   => 'required|in:male,female',
            'birthday' => 'nullable|date',
        ]);

        $users = new Users();
        $users->fill([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => $validated['password'],
            'gender'   => $validated['gender'],
            'birthday' => $validated['birthday'],
            'role_id'  => 2,
            'status'   => 1,
        ]);

        $users->save();
        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {

        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Users::where('email', $request->email)->first();

        if(!$user){
            return back()->withErrors('Tài khoản không tồn tại!');
        }

        if ($user->status != 1) {
            return back()->withErrors(['email' => 'Tài khoản bị khóa']);
        }

        if (Auth::attempt($data)) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành cong!');
        } else {
            return back()->withErrors('Tài khoản hoặc mật khẩu không đúng!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

        public function profile()
        {
              $user = auth()->user();
    return view('user.auth.profile', compact('user'));
        }
}
