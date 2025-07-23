<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Order_detail;
use App\Models\Payment;
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

        // 2. Mặc định phí ship = 30.000 đ
        $shippingFee = 30000;
        // Nếu có selected_items (từ form giỏ hàng gửi lên)
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.view')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để mua.');
        }

        // 3. Lấy giỏ hàng và chi tiết sản phẩm
        $cart = Cart::with('cartDetails.product.')
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        $items = $cart?->cartDetails ?? collect();
        if ($items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 4. Tính tổng tiền sản phẩm
        $total = $items->sum(function ($row) {
            $price = $row->variant ? (float) $row->variant->price : 0;
            return $price * $row->quantity;
        });

        // 5. Cộng thêm phí ship
        $total += $shippingFee;

        // 6. Lấy danh sách phương thức thanh toán
        $payments = Payment::all();

        // 7. Trả dữ liệu về view
        return view('user.orders.index', [
            'cartItems' => $items,
            'shippingFee' => $shippingFee,
            'total' => $total,
            'payments' => $payments
        ]);
    }

    public function store(Request $request)
    {

        if ($request->has('quantities')) {
            foreach ($request->quantities as $detailId => $qty) {
                $detail = Cart_detail::find($detailId);
                if ($detail && $detail->cart->user_id === Auth::id()) {
                    $detail->update([
                        'quantity' => max(1, (int) $qty),
                    ]);
                }
            }
        }
        // 1. Validate input
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'address' => 'required|string',
            'address_id' => 'nullable|exists:addresses,id',
            'payment_id' => 'required|exists:payments,id',
        ]);

        // 2. Tính phí ship
        $address = strtolower($request->address);
        $shipping = str_contains($address, 'hà nội') || str_contains($address, 'ha noi') ? 0 : 30000;

        // 3. Lấy cart + pivot → product → variant
        $cart = Cart::with('cartDetails.product.variants')
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        // $cartItems = $cart ? $cart->cartDetails : collect();
        $items = $cart ? $cart->cartDetails : collect();


        // 4. Tính subtotal dựa trên variant->price
        $subtotal = $items->sum(function ($row) {
            $variant = $row->variant;
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
        $address = new Address();
        $address->user_id = Auth::id();
        $address->address = $request->address;
        $address->save();
        $order = Order::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'payment_id' => $request->payment_id,
            'status_id' => 1,
            'description' => $request->description,
            'address_id' => $address->id,
            'phone'      => $request->phone,
            'total'      => $total,


        ]);

        $data = [];
        foreach ($items as $row) {
            $variant = $row->product->variants->first();
            $unitPrice = $variant ? $variant->price : 0;
            $quantity  = $row->quantity;
            $itemTotal = $unitPrice * $quantity;
            //    dd($variant?->id);

            //         dd([
            //     'order_id' => $order->id,
            //     'product_id' => $row->product->id,
            //     'product_variant_id' => $variant?->id,
            //     'quantity' => $quantity,
            //     'price' => $unitPrice,
            //     'total' => $itemTotal,
            // ]);

            $data[] = [
                'order_id'   => $order->id,
                'product_id' => $row->product->id,
                'product_variant_id' => $row->product_variant_id,
                'quantity'   => $quantity,
                'price'      => $unitPrice,
                'total'      => $itemTotal,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($data)) {
            return redirect()->route('order.index')->with('error', 'Chưa có sản phẩm nào trong giỏ hàng!');
        }

        Order_detail::insert($data);

        // 9. Xóa pivot để giỏ trống
        if ($cart) {
            $cart->cartDetails()->delete();
        }

        return redirect()
            ->route('order.success')
            ->with('success', 'Đặt hàng thành công!');
    }
    public function checkoutSelected(Request $request)
    {
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.view')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để mua.');
        }

        $cartDetails = Cart_detail::whereIn('id', $selectedIds)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['product', 'variant'])
            ->get();

        return view('user.orders.checkout', compact('cartDetails'));
    }
}
