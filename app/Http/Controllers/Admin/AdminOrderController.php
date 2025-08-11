<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with(['user', 'status', 'payment'])
                       ->orderByDesc('created_at')
                       ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with([
            'user',
            'address',
            'status',
            'payment',
            'orderDetails.product',
            'orderDetails.product.variants.variantValues'
        ])->findOrFail($id);

        $statuses = Status::all();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $order = Order::findOrFail($id);
        $newStatusId = (int) $request->status_id;

        // Ngăn không cho quay lại trạng thái trước đó
        if ($newStatusId < $order->status_id) {
            return redirect()->back()->with('error', '❌ Không thể quay lại trạng thái trước đó!');
        }

        $order->status_id = $newStatusId;
        $order->save();

        return redirect()->route('orders.show', $order->id)
                         ->with('success', '✅ Cập nhật trạng thái thành công!');
    }
}
