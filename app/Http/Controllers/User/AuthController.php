<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        $users = new User();
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
        // 1. Tạo validator với rule cơ bản
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'email.max'         => 'Email quá dài.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải ít nhất 6 ký tự.',
        ]);

        // 2. Thêm điều kiện kiểm tra user có tồn tại & bị khóa không
        $validator->after(function ($validator) use ($request) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $validator->errors()->add('email', 'Tài khoản không tồn tại!');
            } elseif ($user->status != 1) {
                $validator->errors()->add('email', 'Tài khoản đã bị khóa! Vui lòng liên hệ qua đường dây lóng');
            }
        });

        // 3. Nếu có lỗi thì quay lại với lỗi
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        // 4. Đăng nhập
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Phân quyền sau khi đăng nhập
            $role = Auth::User()->role_id;

            if ($role === 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công với quyền Admin!');
            } else {
                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            }
        }

        // 5. Sai mật khẩu
        return back()
            ->withErrors(['password' => 'Tài khoản hoặc mật khẩu không đúng!'])
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        $user = auth()->user();

        $orders = Order::with([
            'orderDetails.product',
            'orderDetails.productVariant.attributeValues.attribute',
            'payment',
            'status'
        ])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return view('user.auth.profile', compact('user', 'orders'));
    }
}
