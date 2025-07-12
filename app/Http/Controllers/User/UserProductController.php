<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product_variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    /**
     * Thêm sản phẩm vào giỏ hàng (dùng database)
     */
    public function addToCart(Request $request, $variantId)
    {
        // 1. Bảo đảm user đã login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ.');
        }

        // 2. Lấy variant kèm product
        $variant = Product_variant::with('product')->findOrFail($variantId);
        $product = $variant->product;

        // 3. Số lượng muốn thêm
        $qty = max(1, (int)$request->input('quantity', 1));

        // 4. Lấy hoặc tạo Cart duy nhất cho user
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        // 5. Thêm hoặc cộng dồn vào cart_details, match cả product_id và variant_id
        $detail = $cart->cartDetails()
                       ->where('product_id', $product->id)
                       ->first();

        if ($detail) {
            // cộng thêm
            $detail->increment('quantity', $qty);
        } else {
            // tạo mới
            $cart->cartDetails()->create([
                'product_id' => $product->id,
                'quantity'   => $qty,
            ]);
        }

        return redirect()->back()
                         ->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * Hiển thị trang giỏ hàng (dữ liệu từ DB)
     */
    public function cart()
    {
        $cart = Cart::with('cartDetails.product.variants')
                    ->where('user_id', Auth::id())
                    ->latest('id')
                    ->first();

        $items = $cart ? $cart->cartDetails : collect();
        return view('user.cart.cart', compact('items'));
    }

    /**
     * Cập nhật số lượng từng item trong giỏ
     */
    public function updateCart(Request $request)
    {
        foreach ($request->input('quantities', []) as $detailId => $qty) {
            $detail = Cart_detail::find($detailId);
            if ($detail && $detail->cart->user_id === Auth::id()) {
                $detail->update([
                    'quantity' => max(1, (int)$qty),
                ]);
            }
        }
        return back()->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    /**
     * Xóa 1 item khỏi giỏ
     */
    public function removeFromCart($detailId)
    {
        $detail = Cart_detail::find($detailId);
        if ($detail && $detail->cart->user_id === Auth::id()) {
            $detail->delete();
        }
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng của user
     */
    public function clearCart()
    {
        Cart_detail::whereHas('cart', function($q) {
            $q->where('user_id', Auth::id());
        })->delete();

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
