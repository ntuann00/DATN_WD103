<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with(['user', 'orderDetails.product', 'address'])->orderByDesc('created_at')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
 public function show($id)
{
    $order = Order::with(['user', 'address', 'orderDetails.product'])->findOrFail($id);
    return view('admin.orders.show', compact('order'));
}


}
