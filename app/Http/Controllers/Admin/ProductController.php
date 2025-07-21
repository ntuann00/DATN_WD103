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
    public function index()
    {
        $products = Product::with(['category', 'variants'])->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();

        return view('admin.products.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'brand' => $request->input('brand')
        ]);

        foreach ($request->input('variants', []) as $index => $variantData) {
            if (empty($variantData['sku']) || empty($variantData['price'])) {
                continue;
            }

            $variant = $product->variants()->create([
                'sku' => $variantData['sku'],
                'price' => $variantData['price'],
                'quantity' => $variantData['quantity'] ?? 0,
            ]);

            foreach ($variantData['attributes'] ?? [] as $attributeId => $attributeValueId) {
                if ($attributeValueId) {
                    Product_variant_value::create([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $attributeValueId,
                    ]);
                }
            }

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

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show(string $id)
    {
        $product = Product::with([
            'variants.images',
            'variants.variantValues.attributeValue.attribute'
        ])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::with(['category', 'variants.images', 'variants.variantValues.attributeValue.attribute'])->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->only([
            'name',
            'description',
            'category_id',
            'brand'
        ]));

        foreach ($request->variants as $variantId => $variantData) {
            $variant = Product_variant::find($variantId);

            if ($variant) {
                $variant->update([
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'quantity' => $variantData['quantity']
                ]);

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

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xoá sản phẩm thành công!');
    }
}
resources/views/user/products/product-detail.blade.php