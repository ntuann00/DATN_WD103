<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VNPayController;
use App\Models\Address;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Order_detail;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;


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

        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.view')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để mua.');
        }

        // 3. Lấy giỏ hàng và chi tiết sản phẩm
        $cart = Cart::with([

            'cartDetails.variant.attributeValues.attribute',
            'cartDetails.product'
        ])
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();


        $items = $cart?->cartDetails->whereIn('id', $selectedIds) ?? collect();
        foreach ($items as $row) {
            $variant = $row->variant;

            if (!$variant) {
                return back()->with('error', 'Không tìm thấy biến thể của sản phẩm "' . $row->product->name . '".');
            }

            if ($row->quantity > $variant->quantity) {
                return back()->with('error', 'Sản phẩm "' . $row->product->name . '" chỉ còn ' . $variant->quantity . ' sản phẩm trong kho.');
            }
        }
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

        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để mua.');
        }

        session(['selected_items' => $selectedIds]);


        // $cart = Cart::with(['cartDetails' => function ($query) use ($selectedIds) {
        //     $query->whereIn('id', $selectedIds);
        // }, 'cartDetails.product.variants'])
        //     ->where('user_id', Auth::id())
        //     ->latest('id')
        //     ->first();
        $cart = Cart::where('user_id', Auth::id())->latest('id')->first();

        // 2. Load lại cartDetails kèm variant và product
        $cart->load([
            'cartDetails' => function ($query) use ($selectedIds) {
                $query->whereIn('id', $selectedIds);
            },
            'cartDetails.product.variants',
            'cartDetails.variant',
        ]);

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

            $variant = $row->variant;
            // $variant = $row->product->variants->first();

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


            if (empty($data)) {
                return redirect()->route('order.index')->with('error', 'Chưa có sản phẩm nào trong giỏ hàng!');
            }


            // 8. Tạo order_details
            OrderDetail::insert($data);

            // 9. Xử lý theo payment_id
            if ($request->payment_id == 4) {
                // Thanh toán COD: xoá sản phẩm đã mua trong giỏ
                if ($cart) {
                    $cart->cartDetails()->whereIn('id', $selectedIds)->delete();
                }
                session()->forget('selected_items');

                return redirect()
                    ->route('order.success')
                    ->with('success', 'Đặt hàng thành công!');
            }

            if ($request->payment_id == 5) {
                $request->merge([
                    'total' => $total,
                    'order_id' => $order->id
                    // KHÔNG tạo order ở đây
                ]);

                $vnpay = new VNPayController();
                return $vnpay->create($request); // chỉ truyền dữ liệu
            }

            return back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
        // public function checkoutSelected(Request $request)
        // {
        //     $selectedIds = $request->input('selected_items', []);

        //     if (empty($selectedIds)) {
        //         return redirect()->route('cart.view')->with('error', 'Vui lòng chọn ít nhất một sản phẩm để mua.');
        //     }

        //     $cartDetails = Cart_detail::whereIn('id', $selectedIds)
        //         ->whereHas('cart', function ($query) {
        //             $query->where('user_id', Auth::id());
        //         })
        //         ->with(['product', 'variant'])
        //         ->get();

        //     return view('user.orders.checkout', compact('cartDetails'));
        // }
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status_id >= 6) {
            return back()->with('error', 'Không thể hủy đơn hàng đang giao hoặc đã giao.');
        }

        $order->status_id = 8; // 8 = Đã hủy
        $order->cancel_reason = $request->cancel_reason; //  lưu lý do
        $order->save();

        return back()->with('success', 'Đơn hàng đã được hủy.');
    }

    // Hoàn hàng
    public function return($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status_id != 7) {
            return back()->with('error', 'Chỉ hoàn hàng khi đơn đã được nhận.');
        }

        $order->status_id = 9;
        $order->save();

        return back()->with('success', 'Yêu cầu hoàn hàng đã được gửi.');
    }

    // tạo phương thwusc thanh toán

    public function createPayment(Request $request)
    {
        try {
            // Nếu dùng payment_id (4 = COD, 5 = VNPAY)
            if ($request->payment_id == 5) {
                $vnpay = new VNPayController();
                return $vnpay->create($request);
            }

            return $this->store($request);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    }


    public function show($id)
    {
        $order = Order::with(['orderDetails.product'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }



    /**
     * Người dùng xác nhận đã nhận hàng → chuyển đến form review
     */
    public function confirmReceived($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_id', 7) // chỉ khi giao thành công
            ->firstOrFail();

        return redirect()->route('orders.review.form', $order->id);
    }

    /**
     * Hiện form đánh giá
     */
    public function reviewForm($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_id', 7)
            ->firstOrFail();

        return view('user.orders.review', compact('order'));
    }

    /**
     * Lưu đánh giá
     */
    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_id', 7) // giao hàng thành công
            ->firstOrFail();

        // Lấy danh sách sản phẩm trong đơn hàng
        foreach ($order->orderDetails as $orderDetail) {
            Review::create([
                'user_id'    => Auth::id(),
                'product_id' => $orderDetail->product_id, // ✅ gắn với sản phẩm
                'rating'     => $request->rating,
                'comment'    => $request->comment,
            ]);
        }




        return redirect()->route('order.index')
            ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
