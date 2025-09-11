<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Tổng khách hàng
        $totalUsers = User::count();

        // Tổng đơn hàng
        $totalOrders = Order::count();

        // Doanh thu (tính đơn hàng giao thành công)
        $totalRevenue = Order::where('status_id', 7)->sum('total');

        // Sản phẩm bán chạy nhất
        $bestSelling = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->first();

        // Tổng bình luận
        $totalReviews = Review::count();

        // Doanh thu theo tháng (12 tháng gần nhất)
        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('status_id', 7)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Top 5 sản phẩm bán chạy
        $topProducts = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        return view('admin.statistics.index', compact(
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'bestSelling',
            'totalReviews',
            'revenueByMonth',
            'topProducts'
        ));
    }
}
