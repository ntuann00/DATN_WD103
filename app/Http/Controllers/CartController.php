<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem; // Đừng quên import model
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'nullable|string',
            'capacity' => 'nullable|string',
            'scent' => 'nullable|string',
            'texture' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Kiểm tra nếu sản phẩm với thuộc tính đã tồn tại trong giỏ
        $item = CartItem::where('product_id', $validated['product_id'])
            ->where('color', $validated['color'] ?? null)
            ->where('capacity', $validated['capacity'] ?? null)
            ->where('scent', $validated['scent'] ?? null)
            ->where('texture', $validated['texture'] ?? null)
            ->first();

        if ($item) {
            // Tăng số lượng
            $item->increment('quantity', $validated['quantity']);
        } else {
            // Tạo mới
            CartItem::create($validated);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }
}
