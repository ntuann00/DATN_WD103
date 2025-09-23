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

        $status_id = $refund->status_description == 0 ? 8 : 9;

        $refund = Refund::with(['order.orderDetails' => function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        }])->findOrFail($id);

        $refund_info = Refund_info::where('refund_id', $refund->id)
            ->first();
        $user = User::where('id', $refund->user_id)->first();
        // dd($refund->user_id);
        // $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();
        return view('admin.refund.detail', compact('refund', 'refund_info', 'user'));
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

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'refund_id' => 'required|exists:refunds,id',
                'status' => 'required|in:approved,rejected',
            ]);

            $refund = Refund::findOrFail($request->refund_id);

            // Check current status
            if ($refund->status !== 'Đang xử lý') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể cập nhật trạng thái cho yêu cầu này'
                ], 400);
            }

            // Update status
            $refund->status = $request->status == 'approved' ? 'Đã duyệt' : 'Đã từ chối';

            $refund->updated_at = now();

            $refund->save();

            // Optional: Send notification to customer
            // $this->sendNotificationToCustomer($refund);

            // Return success response
            $messages = [
                'approved' => 'Yêu cầu hoàn tiền đã được duyệt',
                'rejected' => 'Yêu cầu hoàn tiền đã bị từ chối',
                'completed' => 'Hoàn tiền đã hoàn thành'
            ];

            return response()->json([
                'success' => true,
                'message' => $messages[$request->status] ?? 'Cập nhật thành công',
                'data' => $refund
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
