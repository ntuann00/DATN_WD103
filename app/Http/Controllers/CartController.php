<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $item = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('color', $request->color)
            ->where('capacity', $request->capacity)
            ->where('scent', $request->scent)
            ->where('texture', $request->texture)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'sku' => $request->sku,
                'color' => $request->color,
                'capacity' => $request->capacity,
                'scent' => $request->scent,
                'texture' => $request->texture,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cập nhật thành công!');
    }

    public function remove($id)
    {
        CartItem::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Đã xoá sản phẩm!');
    }

    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Đã xoá toàn bộ giỏ hàng!');
    }
}

