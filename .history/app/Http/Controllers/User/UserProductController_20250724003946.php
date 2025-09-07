<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    /**
     * Thêm sản phẩm vào giỏ hàng (dùng database)
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ.');
        }

        // ✅ Lấy variant ID từ form
        $attributeValues = $request->input('attribute'); // mảng [5, 8] chẳng hạn

        $product = Product::where('id', $request->input('product_id'))
            ->first();

        $variant = ProductVariant::where('product_id', $request->input('product_id'))
            ->whereHas('attributeValues', function ($query) use ($attributeValues) {
                $query->whereIn('attribute_value_id', $attributeValues);
            }, '=', count($attributeValues)) // Đảm bảo variant có đủ số lượng value
            ->with('attributeValues') // Nếu cần xem thêm
            ->first(); // Hoặc get() nếu muốn lấy nhiều

        $qty = max(1, (int)$request->input('quantity', 1));

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        $detail = $cart->cartDetails()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $product->variants->id)
            ->first();

        if ($detail) {
            $detail->increment('quantity', $qty);
        } else {
            $cart->cartDetails()->create([
                'product_id' => $product->id,
                'product_variant_id' => $product->variants->id,
                'quantity' => $qty,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }


    /**
     * Hiển thị trang giỏ hàng (dữ liệu từ DB)
     */
    public function cart()
    {
        $cart = Cart::with([
            'cartDetails.variant.attributeValues.attribute', // load biến thể và thuộc tính
            'cartDetails.product'
        ])->where('user_id', Auth::id())->latest()->first();

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
        Cart_detail::whereHas('cart', function ($q) {
            $q->where('user_id', Auth::id());
        })->delete();

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
