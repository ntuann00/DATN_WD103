<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'variants'])->paginate(4);
        return view('admin.products.index', compact('products'));
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
        $product = Product::with(['variants.variantValues.attributeValue.attribute'])->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['category', 'variants.images', 'variants.variantValues.attributeValue.attribute'])->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

    // ✅ Cập nhật thông tin sản phẩm gốc
        $product->update($request->only([
            'name',
            'description',
            'category_id',
            'brand'
        ]));

        // ✅ Lặp qua từng biến thể được gửi từ form
        foreach ($request->variants as $variantId => $variantData) {
            $variant = Product_variant::find($variantId);

            if ($variant) {
                // ✅ Cập nhật thông tin biến thể
                $variant->update([
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'quantity' => $variantData['quantity']
                ]);

                // ✅ Kiểm tra và xử lý ảnh mới (nếu có) cho biến thể này
                if ($request->hasFile("variant_images.$variantId")) {
                    $images = $request->file("variant_images.$variantId");

                    foreach ($images as $index => $image) {
                        $path = $image->store('products', 'public');

                        $variant->images()->create([
                            'image_url' => 'storage/' . $path,
                            'alt_text' => $variant->sku . ' - ảnh ' . ($index + 1),
                            'sort_order' => $index + 1
                        ]);
                    }
                }
            }
        }

        return redirect()->route('products.edit', $id)->with('success', 'Cập nhật sản phẩm và ảnh biến thể thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xoá sản phẩm thành công!');
    }
}
