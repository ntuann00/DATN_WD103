<?php
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes

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

<<<<<<< Updated upstream
        // ✅ Lấy variant ID từ form
        $attributeValues = $request->input('attribute'); // mảng [5, 8] chẳng hạn

        $product = Product::where('id', $request->input('product_id'))
            ->first();

=======

        // ✅ Lấy variant ID từ form
        $attributeValues = $request->input('attribute'); // mảng [5, 8] chẳng hạn


        $product = Product::where('id', $request->input('product_id'))
            ->first();


>>>>>>> Stashed changes
        $variant = ProductVariant::where('product_id', $request->input('product_id'))
            ->whereHas('attributeValues', function ($query) use ($attributeValues) {
                $query->whereIn('attribute_value_id', $attributeValues);
            }, '=', count($attributeValues)) // Đảm bảo variant có đủ số lượng value
            ->with('attributeValues') // Nếu cần xem thêm
            ->first(); // Hoặc get() nếu muốn lấy nhiều

<<<<<<< Updated upstream
        $qty = max(1, (int)$request->input('quantity', 1));
=======
        $rawQty = (int)$request->input('quantity', 1);
        $qty = max(1, $rawQty);
        // dd($qty);

>>>>>>> Stashed changes

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        $detail = $cart->cartDetails()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant->id)
            ->first();

<<<<<<< Updated upstream
=======

        $existingQty = $detail ? $detail->quantity : 0;
        $totalQty = $existingQty + $qty;
        // dd([
        //     'tổng cần mua' => $totalQty,
        //     'tồn kho' => $variant->quantity
        // ]);

        if ($totalQty > $variant->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm trong kho chỉ còn ' . $variant->quantity . ' sản phẩm. Vui lòng chọn số lượng phù hợp');
        }
>>>>>>> Stashed changes
        if ($detail) {
            $detail->increment('quantity', $qty);
        } else {
            $cart->cartDetails()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $qty,
            ]);
        }

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }


<<<<<<< Updated upstream
=======


>>>>>>> Stashed changes
    /**
     * Hiển thị trang giỏ hàng (dữ liệu từ DB)
     */
    public function cart()
    {
        $cart = Cart::with([
            'cartDetails.variant.attributeValues.attribute', // load biến thể và thuộc tính
            'cartDetails.product'
        ])->where('user_id', Auth::id())->latest()->first();

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        $items = $cart ? $cart->cartDetails : collect();
        return view('user.cart.cart', compact('items'));
    }

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
    /**
     * Cập nhật số lượng từng item trong giỏ
     */
    public function updateCart(Request $request)
    {
<<<<<<< Updated upstream
        foreach ($request->input('quantities', []) as $detailId => $qty) {
            $detail = Cart_detail::find($detailId);
            if ($detail && $detail->cart->user_id === Auth::id()) {
                $detail->update([
                    'quantity' => max(1, (int)$qty),
                ]);
            }
        }
        return back()->with('success', 'Giỏ hàng đã được cập nhật!');
=======
        $detail = Cart_detail::find($request->id);
        $variant = $detail->variant;

        if ($detail && $detail->cart->user_id === Auth::id()) {
            if ($request->status == 'decrement') {
                if ($detail->quantity > 1) {
                    $detail->update([
                        'quantity' => $detail->quantity - 1,
                    ]);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Đã giảm số lượng',
                    ]);
                }
            } else {
                $newQty = (int) $request->quantities;

                if ($newQty > $variant->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng yêu cầu vượt quá tồn kho!',
                    ]);
                }

                $detail->update([
                    'quantity' => $newQty,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đã cập nhật số lượng',
                ]);
            }
        }

        // ❌ Trường hợp không hợp lệ
        return response()->json([
            'status' => 'error',
            'message' => 'Không thể cập nhật sản phẩm',
        ]);
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

=======


        // Gửi session flash như bình thường
        session()->flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        return response()->json(['reload' => true]);
    }


>>>>>>> Stashed changes
    /**
     * Xóa toàn bộ giỏ hàng của user
     */
    public function clearCart()
    {
        Cart_detail::whereHas('cart', function ($q) {
            $q->where('user_id', Auth::id());
        })->delete();

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
