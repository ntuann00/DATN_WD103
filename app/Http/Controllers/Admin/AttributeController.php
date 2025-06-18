<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AttributeController extends BaseController
{

    public function index()
    {
         $attributes = Attribute::paginate(3);
        return view('admin.attributes.index', compact('attributes'));
    }
    public function create()
    {
        return view('admin.attributes.create');
    }
    public function store(Request $request)
    { 
         $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            Attribute::create($validated);

            return redirect()->route('attributes.index')->with('success', 'Thêm mới thành công!');
    }
    public function show($id)
    {

        
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id) {
        
    }
}

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 1,
        ];

        $cart = session()->get('cart', []);

        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['quantity'] += $product['quantity'];
        } else {
            $cart[$product['id']] = $product;
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->id]);
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function update(Request $request)
{
    $item = CartItem::findOrFail($request->id);
    $item->quantity = $request->quantity;
    $item->save();

    return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
}

}

