<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addToCart($productId, Request $request)
    {
        if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $userId = Auth::id();

        // Tìm hoặc tạo mới Cart cho người dùng hiện tại
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $cartDetail = Cart_detail::where('cart_id', $cart->id)
                        ->where('product_id', $productId)
                        ->first();

        if($cartDetail){
            $cartDetail->quantity += $request->input('quantity', 1);
            $cartDetail->save();
        }else{
            Cart_detail::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $request->input('quantity', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng thành công.');
    }
    // Hiển thi giỏ hàng
    public function index()
    {
        $cartItems = Session::get('cart', []);
        return view('user.cart.index', compact('cartItems'));
    }

    // Cập nhật giỏ hàng
    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
        foreach ($request->quantity as $productId => $quantity) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeProduct($productId)
    {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
    public function viewCart()
    {
        $userId = Auth::id();

        $cart = Cart::with('cartDetails.product')->where('user_id', $userId)->first();

        return view('cart', compact('cart'));
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
    public function store(Request $request)
    {
        //
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
