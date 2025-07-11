<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Promotion;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đặt hàng.');
        }

        $province = $request->input('province', auth()->user()->province);
        $shippingFee = strtolower($province) == 'hà nội' || strtolower($province) == 'ha noi' ? 0 : 30000;

        $cartItems = Cart::where('user_id', auth()->id())->with('product', 'variant')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        }) + $shippingFee;

        return view('user.orders.index', compact('cartItems', 'shippingFee', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_detail' => 'required',
            'payment_method' => 'required|in:cod,visa',
        ]);

        $isHanoi = strtolower($request->province) === 'hà nội' || strtolower($request->province) === 'ha noi';
        $shipping = $isHanoi ? 0 : 30000;

        $cartItems = Cart::where('user_id', auth()->id())->with('product', 'variant')->get();

        // Tính tổng
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discountAmount = 0;
        $voucher = null;
        if ($request->voucher_id) {
            $voucher = Promotion::find($request->voucher_id);
            if ($voucher) {
                $discountAmount = $subtotal * ($voucher->Promotion / 100);
            }
        }

        $total = $subtotal + $shipping - $discountAmount;

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province' => $request->province,
            'district' => $request->district,
            'address_detail' => $request->address_detail,
            'payment_method' => $request->payment_method,
            'total' => $total,
            'shipping_fee' => $shipping,
            'Promotion' => $discountAmount,
        ]);

        foreach ($cartItems as $item) {
            Order_detail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }


}
