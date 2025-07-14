<?php
// sửa lại code 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (nếu có)
     */
    public function index()
    {
        //
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart(Request $request, $variantId)
    {
        $variant = Product_variant::findOrFail($variantId);
        $product = $variant->product;
        $qty = max(1, (int)$request->input('quantity', 1));

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $qty;
        } else {
            $cart[$variantId] = [
                'name'     => $product->name,
                'sku'      => $variant->sku,
                'price'    => $variant->price,
                'image'    => $product->image,
                'quantity' => $qty,
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('user.cart.cart', compact('cart'));
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->forget('cart');
        if (!empty($cart)) {
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->input('quantities') as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int)$quantity);
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    /**
     * Kiểm tra bình luận có chứa từ tục không
     */
    private function containsBadWords($text)
    {
        $bannedWords = ['đm', 'lồn', 'ngu', 'vãi', 'xxx', 'quảng cáo', 'chết'];
        foreach ($bannedWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Hiển thị chi tiết sản phẩm cùng với bình luận sạch
     */
    public function show($id)
    {
        $product = Product::with([
            'variants.images',
            'variants.variantValues.attributeValue.attribute'
        ])->findOrFail($id);

        $reviews = Review::where('product_id', $id)
            ->latest()
            ->get()
            ->filter(function ($review) {
                return !$this->containsBadWords($review->comment);
            });

        return view('user.pages.product_detail', compact('product', 'reviews'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
