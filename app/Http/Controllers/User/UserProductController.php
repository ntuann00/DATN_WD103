<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_variant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class UserProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Thêm sản phẩm vào giỏ hàng

    public function addToCart(Request $request, $variantId)
    {
        // 🛒 Tìm variant theo ID
        $variant = Product_variant::findOrFail($variantId);

        // 🔗 Lấy sản phẩm cha từ relation
        $product = $variant->product;

        // Đọc quantity từ request (nếu không có mặc định =1)
        $qty = max(1, (int)$request->input('quantity', 1));

        // 🛒 Lấy giỏ hàng từ session
        $cart = $request->session()->get('cart', []);

        // ✅ Kiểm tra sản phẩm đã tồn tại trong giỏ chưa
        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $qty;
        } else {
            // ✅ Nếu chưa có, thêm mới sản phẩm vào giỏ
            $cart[$variantId] = [
                'name'     => $product->name,
                'sku'      => $variant->sku,
                'price'    => $variant->price,       // 🎯 Lấy giá từ bảng product_variants
                'image'    => $product->image,       // Ảnh từ bảng products
                'quantity' => $qty,                  // Số lượng từ request
            ];
        }

        // 💾 Lưu giỏ hàng vào session
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    // Hiển thị giỏ hàng
    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('user.cart.cart', compact('cart'));
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->forget('cart'); // Xoá session trước
        if (!empty($cart)) {
            session()->put('cart', $cart); // Ghi lại session
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->input('quantities') as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int)$quantity); // đảm bảo số lượng >=1
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật!');
    }
    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        session()->forget('cart'); // Xóa toàn bộ giỏ hàng
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with([
            'variants.images',
            'variants.variantValues.attributeValue.attribute'
        ])->findOrFail($id);

        return view('user.pages.product_detail', compact('product'));
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
