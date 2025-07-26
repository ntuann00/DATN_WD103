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
        $qty = min($qty, $variant->quantity);
        // dd($qty);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        $detail = $cart->cartDetails()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        $existingQty = $detail ? $detail->quantity : 0;
        $totalQty = $existingQty + $qty;

        if ($totalQty > $variant->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm trong kho không đủ số lượng bạn muốn mua ! Vui lòng kiếm tra lại !');
        }
        if ($detail) {
            $detail->increment('quantity', $qty);
        } else {
            $cart->cartDetails()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
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
        $detail = Cart_detail::find($request->id);
        if ($detail && $detail->cart->user_id === Auth::id()) {
            if ($request->status == 'decrement') {
                if ($detail->quantity > 1) {
                    $detail->update([
                        'quantity' => $detail->quantity - 1,
                    ]);
                }
            } else {
                $detail->update([
                    'quantity' => max(1, (int) $request->quantities),
                ]);
            }
        }
        return response()->json(['message' => 'Cập nhật thành công']);
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

        // Gửi session flash như bình thường
        session()->flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        return response()->json(['reload' => true]);
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
