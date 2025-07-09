<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Hiển thị form checkout
    public function showForm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('warning', 'Giỏ hàng của bạn đang trống!');
        }
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        return view('user.pages.checkout_page', compact('cart','total'));
    }

    /** Xử lý lưu Order và Order_detail */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'description' => 'nullable|string|max:1000',
            // nếu bạn có addresses thì thêm validate cho address_id
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();
        try {
            // Tạo order
            $order = Order::create([
                'user_id'      => Auth::id(),
                'name'         => $request->name,
                'phone'        => $request->phone,
                'description'  => $request->description,
                'address_id'   => null,         // hoặc $request->address_id nếu bạn dùng addresses table
                'status_id'    => 1,            // 1 = pending
                'total'        => collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),
            ]);

            // Tạo chi tiết
            foreach ($cart as $variantId => $item) {
                Order_detail::create([
                    'order_id'   => $order->id,
                    'product_id' => $variantId,               // nếu bạn lưu variant_id thì đổi column DB
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'total'      => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Xóa giỏ
            session()->forget('cart');

            return redirect()->route('order.summary', $order->id)
                             ->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    /** Hiển thị trang Summary */
    public function summary(Order $order)
    {
        $this->authorize('view', $order);
        $details = $order->orderDetails; // relationship
        return view('summary', compact('order','details'));
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkout(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cartItems = Session::get('cart', []);
        // dd($cartItems);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Truyền giỏ hàng vào view
        return view('user.pages.checkout_page', compact('cartItems'));
    }
    public function store(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cartItems = Session::get('cart', []);

        // Kiểm tra giỏ hàng có dữ liệu không
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Tạo đơn hàng mới
        $order = new Order();
        $order->user_id = Auth::id();
        $order->name = $request->fname . ' ' . $request->lname;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->total = $this->calculateTotal($cartItems);
        $order->status_id = 1; // Trạng thái 'Đang xử lý'
        $order->save();

        // Lưu chi tiết đơn hàng
        foreach ($cartItems as $productId => $item) {
            $orderDetail = new Order_detail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $productId;
            $orderDetail->quantity = $item['quantity'];
            $orderDetail->price = $item['price'];
            $orderDetail->total = $item['quantity'] * $item['price'];
            $orderDetail->save();
        }

        // Xóa giỏ hàng sau khi hoàn tất đặt hàng
        Session::forget('cart');

        // Chuyển hướng đến trang xác nhận đơn hàng
        return redirect()->route('order.success', ['order' => $order->id])->with('success', 'Đơn hàng đã được tạo thành công.');
    }

    private function calculateTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
