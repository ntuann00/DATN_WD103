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

        $rawQty = (int)$request->input('quantity', 1);
<<<<<<< HEAD
       $qty = max(1, $rawQty);
        // dd($qty);
=======
        $qty = max(1, $rawQty);
        // dd($qty);

>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );


        $detail = $cart->cartDetails()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant->id)
            ->first();

<<<<<<< HEAD
        $existingQty = $detail ? $detail->quantity : 0;
        $totalQty = $existingQty + $qty;

        if ($totalQty > $variant->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm trong kho không đủ số lượng bạn muốn mua ! Vui lòng kiếm tra lại !');
=======

        $existingQty = $detail ? $detail->quantity : 0;
        $totalQty = $existingQty + $qty;
        // dd([
        //     'tổng cần mua' => $totalQty,
        //     'tồn kho' => $variant->quantity
        // ]);

        if ($totalQty > $variant->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm trong kho chỉ còn ' . $variant->quantity . ' sản phẩm. Vui lòng chọn số lượng phù hợp');
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
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




<<<<<<< HEAD
=======
    /**
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
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
<<<<<<< HEAD

=======
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
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


<<<<<<< HEAD


=======
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
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
