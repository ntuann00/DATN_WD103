<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $order = Order::with('orderDetails')->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status_id', 7) // giao thành công
            ->firstOrFail();

        foreach ($order->orderDetails as $detail) {
            Review::create([
                'user_id'    => Auth::id(),
                'product_id' => $detail->product_id,
                'rating'     => $request->rating,
                'comment'    => $request->comment,
            ]);
        }

        return redirect()->route('order.index')->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
