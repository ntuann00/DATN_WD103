<?php

namespace App\Http\Controllers\Admin;

use App\Models\Refund;
use App\Models\Refund_info;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class RefundController extends BaseController
{
    public function index()
    {
        $refunds = Refund::latest()->paginate(10);
        return view('admin.refund.index', compact('refunds'));
    }

    public function detail($id)
    {
        $refund = Refund::findOrFail($id);
        $refund_info = Refund_info::where('refund_id',$refund->id)->first();
        $user = User::where('id',$refund->user_id)->first();
        // dd($refund->user_id);
        // $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();
        return view('admin.refund.detail', compact('refund','refund_info','user'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role && $user->role->name === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Không thể khóa tài khoản quản trị viên.');
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Đã cập nhật trạng thái tài khoản.');
    }
}
