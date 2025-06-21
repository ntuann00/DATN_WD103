<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_variant_value;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'variants'])->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get(); // Load các giá trị thuộc tính

        return view('admin.products.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ 1. Tạo sản phẩm
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'brand' => $request->input('brand')
        ]);

        // ✅ 2. Lặp qua từng biến thể
        foreach ($request->input('variants', []) as $index => $variantData) {
            // Bỏ qua biến thể trống
            if (empty($variantData['sku']) || empty($variantData['price'])) {
                continue;
            }

        // 2.1. Tạo biến thể
        $variant = $product->variants()->create([
            'sku' => $variantData['sku'],
            'price' => $variantData['price'],
            'quantity' => $variantData['quantity'] ?? 0,
        ]);

        // 2.2. Lưu giá trị thuộc tính con
        foreach ($variantData['attributes'] ?? [] as $attributeId => $attributeValueId) {
            if ($attributeValueId) {
                Product_variant_value::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $attributeValueId,
                ]);
            }
        }

        // 2.3. Xử lý ảnh upload (nếu có)
        if ($request->hasFile("variant_images.$index")) {
            $images = $request->file("variant_images.$index");

            foreach ($images as $imgIndex => $image) {
                $path = $image->store('products', 'public');

                $variant->images()->create([
                    'image_url' => 'storage/' . $path,
                    'alt_text' => $variant->sku . ' - ảnh ' . ($imgIndex + 1),
                    'sort_order' => $imgIndex + 1
                ]);
            }
        }
    }

    return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with([
            'variants.images', // Lấy ảnh cho từng biến thể
            'variants.variantValues.attributeValue.attribute' // Nếu bạn muốn show thuộc tính như Size, Màu
        ])->findOrFail($id);
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
