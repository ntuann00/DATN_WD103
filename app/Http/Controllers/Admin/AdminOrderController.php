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

<<<<<<< HEAD
        $statuses = Status::all();
=======
        // Lấy trạng thái theo thứ tự ID ASC
        $statuses = Status::orderBy('id', 'asc')->get();
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)

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
<<<<<<< HEAD

        // Ngăn không cho quay lại trạng thái trước đó
        if ($newStatusId < $order->status_id) {
            return redirect()->back()->with('error', '❌ Không thể quay lại trạng thái trước đó!');
        }

=======
        $currentStatusId = $order->status_id;

        // Danh sách trạng thái hợp lệ theo thứ tự
        $statusOrder = [1, 2, 3, 4, 5, 6, 7, 9]; // Hoàn hàng = 9
        $cancelStatusId = 8; // Hủy đơn hàng

        // Không cho quay lại trạng thái trước
        if ($newStatusId < $currentStatusId) {
            return redirect()->back()->with('error', '❌ Không thể quay lại trạng thái trước đó!');
        }

        // Không cho hủy nếu đã lấy hàng thành công hoặc hơn
        if ($currentStatusId >= 4 && $newStatusId == $cancelStatusId) {
            return redirect()->back()->with('error', '❌ Không thể hủy đơn hàng sau khi đã lấy hàng thành công!');
        }

        // Kiểm tra đúng thứ tự (trừ khi hủy)
        if ($newStatusId != $cancelStatusId) {
            $currentIndex = array_search($currentStatusId, $statusOrder);
            $nextIndex = $currentIndex + 1;

            if (!isset($statusOrder[$nextIndex]) || $statusOrder[$nextIndex] != $newStatusId) {
                return redirect()->back()->with('error', '❌ Bạn phải cập nhật theo đúng thứ tự trạng thái!');
            }
        }

        // Cập nhật trạng thái
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
        $order->status_id = $newStatusId;
        $order->save();

        return redirect()->route('orders.show', $order->id)
                         ->with('success', '✅ Cập nhật trạng thái thành công!');
    }
}
