<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class AdminController extends BaseController
{
    public function index()
    {
        // Tổng khách hàng (không tính admin)
        $totalUsers = User::where('role_id', '!=', 1)->count();

        // Tổng đơn hàng
        $totalOrders = Order::count();

        // Tổng doanh thu (chỉ tính đơn hàng đã hoàn thành status = 1)
        $totalRevenue = Order::where('status_payment', '1')->where('status', 1)->sum('total');

        // Tổng bình luận
        $totalReviews = Review::count();

        // Doanh thu theo tháng trong năm hiện tại
        $currentYear = date('Y');
        $revenueByMonth = Order::where('status', 1)
            ->where('status_payment', '1') // Sửa từ status_id thành status
            ->whereYear('created_at', $currentYear)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Top 5 sản phẩm bán chạy
        $topProducts = Product::select(
            'products.id',
            'products.name',
            DB::raw('SUM(order_details.quantity) as total_sold'),
            DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
        )
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 1)
            ->where('order_details.status_id', 7)
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        $topProducts->load(['images', 'variants.images']);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'totalReviews',
            'revenueByMonth',
            'topProducts',
        ));
    }
}
