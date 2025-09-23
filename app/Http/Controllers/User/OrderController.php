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
use App\Models\Refund;
use App\Models\Refund_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'cartDetails.product',
            'cartDetails.variant.images'
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
        session()->forget('selected_items');
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
            $name_product = $row->product->name;
            $variant_product = [];
            if ($variant && $variant->attributeValues) {
                foreach ($variant->attributeValues as $attrValue) {
                    $attributeName = $attrValue->attribute->name ?? 'Thuộc tính';
                    $value = $attrValue->value;

                    $variant_product[$attributeName] = $value;
                }
            }
            $variant_product_json = json_encode($variant_product, JSON_UNESCAPED_UNICODE);
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
                'name_product' => $name_product,
                'variant_product' => $variant_product_json,
                'quantity'   => $quantity,
                'price'      => $unitPrice,
                'total'      => $itemTotal,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $row->variant->decrement('quantity', $quantity);
            $row->variant->save();
        }

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

    public function   showOrderDetail($id)
    {
        $order = Order::with([
            'orderDetails.productVariant.images',
            'orderDetails.status',
        ])->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.auth.order-detail', compact('order'));
    }

    public function handleOrderAction(Request $request)
    {
        try {
            $validated = $request->validate([
                'action' => 'required|in:return,cancel',
                'order_id' => 'required|exists:orders,id',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:order_details,id',
                'products.*.reason' => 'required|string|max:500',
                'bank_name' => 'required_if:action,return|string|max:255',
                'account_number' => 'required_if:action,return|string|max:50',
                'account_holder' => 'required_if:action,return|string|max:255',
            ]);

            // Kiểm tra quyền sở hữu đơn hàng
            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();

            DB::beginTransaction();

            $totalRefundAmount = 0;
            $reasons = [];
            $shippingFee = 30000; // Phí ship cố định

            foreach ($validated['products'] as $product) {
                $orderDetail = OrderDetail::findOrFail($product['id']);

                // Kiểm tra orderDetail thuộc order này
                if ($orderDetail->order_id !== $order->id) {
                    throw new \Exception('Sản phẩm không thuộc đơn hàng này');
                }

                // Kiểm tra status hợp lệ
                if ($validated['action'] === 'cancel' && $orderDetail->status_id !== 1) {
                    throw new \Exception('Sản phẩm không thể hủy');
                }

                if ($validated['action'] === 'return' && $orderDetail->status_id !== 7) {
                    throw new \Exception('Sản phẩm không thể hoàn');
                }

                // Cập nhật status
                $newStatus = $validated['action'] == 'cancel' ? 8 : 9;

                if ($newStatus == 8) {
                    $orderDetail->productVariant->increment('quantity', $orderDetail->quantity);
                    $orderDetail->productVariant->save();
                }

                $orderDetail->update([
                    'status_id' => $newStatus,
                    'reason' => $product['reason'],
                    'updated_at' => now()
                ]);

                // Tính toán số tiền hoàn trả cho sản phẩm này
                $totalRefundAmount += $orderDetail->total;
                $reasons[] = $product['reason'];
            }

            // Đếm số lượng sản phẩm theo status
            $orderDetails = $order->orderDetails;
            $totalProducts = $orderDetails->count();
            $cancelledCount = $orderDetails->where('status_id', 8)->count();
            $returnedCount = $orderDetails->where('status_id', 9)->count();

            if ($returnedCount == $totalProducts) {
                $order->update([
                    'status_id' => 9
                ]);
            } else if ($cancelledCount == $totalProducts) {
                $order->update([
                    'status_id' => 8
                ]);
            }

            // Xử lý logic trừ tiền
            if ($validated['action'] == 'return') {
                // Hoàn hàng: LUÔN giữ lại 30,000 tiền ship
                $remainingOrderTotal = $order->total - $totalRefundAmount;

                // Đảm bảo luôn giữ lại ít nhất 30,000 tiền ship
                if ($remainingOrderTotal < $shippingFee) {
                    $remainingOrderTotal = $shippingFee;
                }
            } else if ($validated['action'] == 'cancel') {
                // Hủy đơn
                if ($cancelledCount == $totalProducts) {
                    // Nếu hủy TẤT CẢ sản phẩm: hoàn cả tiền ship
                    $remainingOrderTotal = 0;
                } else {
                    // Nếu hủy một phần: giữ lại tiền ship
                    $remainingOrderTotal = $order->total - $totalRefundAmount;

                    // Đảm bảo giữ lại ít nhất tiền ship nếu còn sản phẩm
                    if ($remainingOrderTotal < $shippingFee) {
                        $remainingOrderTotal = $shippingFee;
                    }
                }
            }

            // Cập nhật tổng tiền đơn hàng
            $order->update([
                'total' => max(0, $remainingOrderTotal)
            ]);

            // Xử lý hoàn tiền nếu đã thanh toán
            if ($order->status_payment == 1 && $totalRefundAmount > 0) {
                $description = 'Yêu cầu hoàn tiền';

                // Thêm lý do vào mô tả
                if (!empty($reasons)) {
                    $description .= '. Lý do: ' . implode('; ', array_unique($reasons));
                }

                $status_description = 0;

                // Thêm thông tin về phí ship
                if ($validated['action'] === 'return') {
                    $description .= ' (Đã giữ lại phí vận chuyển 30,000đ)';
                    $status_description = 1;
                } else if ($validated['action'] == 'cancel' && $cancelledCount == $totalProducts) {
                    $description .= ' (Hoàn tiền)';
                }

                // Tạo 1 bản ghi hoàn tiền duy nhất
                $refund = Refund::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'reason' => 'Hoàn tiền',
                    'total' => $totalRefundAmount ?? 0,
                    'description' => $description,
                    'status_description' => $status_description
                ]);

                Refund_info::create([
                    'refund_id' => $refund->id,
                    'bank_name' => $validated['bank_name'],
                    'bank_number' => $validated['account_number'],
                    'bank_holder' => $validated['account_holder'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $validated['action'] === 'cancel'
                    ? 'Hủy sản phẩm thành công'
                    : 'Yêu cầu hoàn hàng đã được gửi',
                'refund_amount' => $actualRefundAmount ?? 0,
                'remaining_total' => $remainingOrderTotal,
                'shipping_fee_kept' => $remainingOrderTotal >= $shippingFee
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order action error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
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


    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order = Order::with('orderDetails.productVariant')->where('user_id', auth()->id())->findOrFail($id);

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

        return redirect()->route('profile')
            ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
