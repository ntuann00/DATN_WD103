<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // 1. Nếu chưa login thì chuyển về login
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Bạn cần đăng nhập để đặt hàng.');
        }

        // 2. Tính phí ship
        $province    = $request->input('province', Auth::user()->province);
        $normalized  = strtolower($province);
        $shippingFee = in_array($normalized, ['ha noi','hà nội']) ? 0 : 30000;

        // 3. Lấy cart mới nhất của user cùng pivot → product → variant
        $cart = Cart::with('cartDetails.product.variant')
                    ->where('user_id', Auth::id())
                    ->latest('id')
                    ->first();

        // 4. Lấy items hoặc dùng Collection rỗng
        $items = $cart ? $cart->cartDetails : collect();

        // 5. Tính tổng tiền hàng dựa trên variant->price

        $total = $items->sum(function($row) {
                    $variant = $row->product->variant;
                    // $price   = $variant ? $variant->price : 0;
                    return ($variant ? $variant->price : 0) * $row->quantity;
                })
                + $shippingFee;

        // return view('user.orders.index', compact(
        //     'cartItems', 'shippingFee', 'total'
        // ));
        return view('user.orders.index', [
            'cartItems'   => $items,
            'shippingFee' => $shippingFee,
            'total'       => $total,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'name'           => 'required|string',
            'phone'          => 'required',
            'province'       => 'required',
            'district'       => 'required',
            'address_detail' => 'required',
            'payment_method' => 'required|in:cod,visa',
            'voucher_id'     => 'nullable|exists:discounts,id',
        ]);

        // 2. Tính phí ship
        $province = strtolower($request->province);
        $shipping = in_array($province, ['ha noi','hà nội']) ? 0 : 30000;

        // 3. Lấy cart + pivot → product → variant
        $cart = Cart::with('cartDetails.product.variant')
                    ->where('user_id', Auth::id())
                    ->latest('id')
                    ->first();

        // $cartItems = $cart ? $cart->cartDetails : collect();
        $items = $cart ? $cart->cartDetails : collect();

        // 4. Tính subtotal dựa trên variant->price
        // $subtotal = $cartItems->sum(function($row) {
        $subtotal = $items->sum(function($row) {
            $variant = $row->product->variant;
            // $price   = $variant ? $variant->price : 0;
            // return $price * $row->quantity;
            return ($variant ? $variant->price : 0) * $row->quantity;
        });

        // 5. Tính discount (nếu có)
        $discountAmount = 0;
        if ($voucherId = $request->voucher_id) {
            $voucher = Discount::find($voucherId);
            if ($voucher) {
                $discountAmount = $subtotal * ($voucher->discount_value / 100);
            }
        }

        // 6. Tổng thanh toán
        $total = $subtotal + $shipping - $discountAmount;

        // 7. Tạo Order
        $order = Order::create([
            'user_id'        => Auth::id(),
            'name'           => $request->name,
            'phone'          => $request->phone,
            'address_id' => $request->address_id,
            'payment_id' => $request->payment_id,
            // 'shipping_fee'   => $shipping,
            'discount'       => $discountAmount,
            'total'          => $total,
        ]);

        // 8. Tạo Order_detail: price lấy từ variant->price
        // foreach ($cartItems as $row) {
        foreach ($items as $row) {
            $variant   = $row->product->variant;
            $unitPrice = $variant ? $variant->price : 0;

            Order_detail::create([
                'order_id'   => $order->id,
                'product_id' => $row->product->id,
                'variant_id' => $variant ? $variant->id : null,
                'price'      => $unitPrice,
                'quantity'   => $row->quantity,
            ]);
        }

        // 9. Xóa pivot để giỏ trống
        if ($cart) {
            $cart->cartDetails()->delete();
        }

        return redirect()
            ->route('order.success')
            ->with('success', 'Đặt hàng thành công!');
    }
}
