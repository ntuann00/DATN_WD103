<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Product_variant_value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::with(['category', 'variants'])->latest()->paginate(5);
        // return view('admin.products.index', compact('products'));
        $products = Product::with(['images','variants.images','category'])
                       ->latest()
                       ->paginate(15);
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
//    public function store(Request $request)
// {
//     // ✅ 1. Tạo sản phẩm
//    $product = Product::create([
//     'name' => $request->input('name'),
//     'productVariant_id' => $request->input('productVariant_id') ?? null,
//     'category_id' => $request->input('category_id'),
//     'attribute_id' => $request->input('attribute_id') ?? null, // có thể null
//     'promotion_id' => $request->input('promotion_id') ?? null, // có thể null
//     'brand' => $request->input('brand'),
//     'description' => $request->input('description'),
//     'status' => $request->input('status', true),

// ]);

//     // ✅ 2. Lặp qua từng biến thể
//     foreach ($request->input('variants', []) as $index => $variantData) {
//         // Bỏ qua biến thể trống
//         if (empty($variantData['sku']) || empty($variantData['price'])) {
//             continue;
//         }

//         // 2.1. Tạo biến thể
//         $variant = $product->variants()->create([
//             'sku' => $variantData['sku'],
//             'price' => $variantData['price'],
//             'quantity' => $variantData['quantity'] ?? 0,
//         ]);

//         // 2.2. Lưu giá trị thuộc tính con
//         foreach ($variantData['attributes'] ?? [] as $attributeId => $attributeValueId) {
//             if ($attributeValueId) {
//                 Product_variant_value::create([
//                     'variant_id' => $variant->id,
//                     'attribute_value_id' => $attributeValueId,
//                 ]);
//             }
//         }

//         // 2.3. Xử lý ảnh upload (nếu có)
//         if ($request->hasFile("variant_images.$index")) {
//             $images = $request->file("variant_images.$index");

//             foreach ($images as $imgIndex => $image) {
//                 $path = $image->store('products', 'public');

//                 $variant->images()->create([
//                     'image_url' => 'storage/' . $path,
//                     'alt_text' => $variant->sku . ' - ảnh ' . ($imgIndex + 1),
//                     'sort_order' => $imgIndex + 1,
//                 ]);
//             }
//         }
//     }

//     return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
// }

     public function store(Request $request)
    {
        // 1. Tạo product chính
        $product = Product::create([
            'name'        => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'brand'       => $request->input('brand'),
            'description' => $request->input('description'),
            'status'      => $request->input('status', 1),
        ]);

        // 2. Lưu ảnh sản phẩm chung (product-level) vào cột product_id
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_url' => 'storage/' . $path,
                    'alt_text'  => $product->name . ' - ảnh ' . ($i + 1),
                    'sort_order'=> $i + 1,
                ]);
            }
        }

        // 3. Xử lý variants
        $variants = $request->input('variants', []);
        if (empty($variants)) {
            // Không có biến thể con: tạo mặc định từ form cơ bản
            $product->variants()->create([
                'sku'      => $request->input('sku'),
                'price'    => $request->input('price'),
                'quantity' => $request->input('stock', 0),
            ]);
        } else {
            foreach ($variants as $index => $variantData) {
                if (empty($variantData['sku']) || empty($variantData['price'])) {
                    continue;
                }
                // Tạo variant con
                $variant = $product->variants()->create([
                    'sku'      => $variantData['sku'],
                    'price'    => $variantData['price'],
                    'quantity' => $variantData['quantity'] ?? 0,
                ]);

                // Lưu attribute values
                foreach ($variantData['attributes'] ?? [] as $attrId => $valId) {
                    if ($valId) {
                        Product_variant_value::create([
                            'variant_id'         => $variant->id,
                            'attribute_value_id' => $valId,
                        ]);
                    }
                }

                // Lưu ảnh variant (variant-level) vào cột product_variant_id
                if ($request->hasFile("variant_images.$index")) {
                    foreach ($request->file("variant_images.$index") as $j => $img) {
                        $p = $img->store('products', 'public');
                        $variant->images()->create([
                            'image_url'  => 'storage/' . $p,
                            'alt_text'   => $variant->sku . ' - ảnh ' . ($j + 1),
                            'sort_order' => $j + 1,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('products.index')
                         ->with('success', 'Thêm sản phẩm thành công!');
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

    public function edit($id)
    {
        $product = Product::with([
            'images',
            'variants.images',
            'variants.variantValues',
        ])->findOrFail($id);

        // Nếu chưa có variant nào, thêm dummy để form basic luôn hiển thị SKU/price/stock
        if ($product->variants->isEmpty()) {
            $product->setRelation('variants', collect([
                new ProductVariant([
                    'id'       => null,
                    'sku'      => '',
                    'price'    => null,
                    'quantity' => null,
                ])
            ]));
        }

        $categories = \App\Models\Category::all();
        $attributes = \App\Models\Attribute::with('values')->get();

        return view('admin.products.edit', compact('product','categories','attributes'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1) Update product-level fields
        $product->update($request->only([
            'name','category_id','brand','description','status'
        ]));

        // 2) Lấy input variants (nếu có)
        $inputVariants = $request->input('variants', []);

        // 3) Nếu form chỉ sửa basic section (không có variants[]),
        //    thì tạo hoặc update variant đầu tiên
        if (empty($inputVariants)) {
            $first = $product->variants()->first();
            if ($first) {
                // update
                $first->update([
                    'sku'      => $request->input('sku'),
                    'price'    => $request->input('price'),
                    'quantity' => $request->input('stock', 0),
                ]);
            } else {
                // create mới
                $product->variants()->create([
                    'sku'      => $request->input('sku') ?? Str::upper(Str::random(6)),
                    'price'    => $request->input('price'),
                    'quantity' => $request->input('stock', 0),
                ]);
            }
        }

        // 4) Nếu có variants[] block, sync tất cả
        if (! empty($inputVariants)) {
            $existingIds = $product->variants->pluck('id')->toArray();
            $keep = [];

            foreach ($inputVariants as $idx => $data) {
                // Bỏ qua các slot trống (yêu cầu ít nhất SKU + price)
                if (empty($data['sku']) || empty($data['price'])) {
                    continue;
                }

                // Tạo mới hoặc update
                if (! empty($data['id']) && in_array($data['id'], $existingIds)) {
                    $variant = ProductVariant::find($data['id']);
                    $variant->update([
                        'sku'      => $data['sku'],
                        'price'    => $data['price'],
                        'quantity' => $data['quantity'] ?? 0,
                    ]);
                } else {
                    $variant = $product->variants()->create([
                        'sku'      => $data['sku'],
                        'price'    => $data['price'],
                        'quantity' => $data['quantity'] ?? 0,
                    ]);
                }
                $keep[] = $variant->id;

                // Sync attribute values
                $variant->variantValues()->delete();
                foreach ($data['attributes'] ?? [] as $attrId => $valId) {
                    if ($valId) {
                        Product_variant_value::create([
                            'variant_id'         => $variant->id,
                            'attribute_value_id' => $valId,
                        ]);
                    }
                }

                // Sync variant-level images
                if ($request->hasFile("variant_images.$idx")) {
                    // xóa cũ
                    foreach ($variant->images as $oldImg) {
                        Storage::disk('public')->delete(str_replace('storage/','',$oldImg->image_url));
                    }
                    $variant->images()->delete();
                    // lưu mới
                    foreach ($request->file("variant_images.$idx") as $j => $img) {
                        $path = $img->store('products','public');
                        $variant->images()->create([
                            'image_url'  => 'storage/'.$path,
                            'alt_text'   => "{$variant->sku} - ảnh ".($j+1),
                            'sort_order' => $j+1,
                        ]);
                    }
                }
            }

            // Xóa các variant đã bị loại bỏ
            $toRemove = array_diff($existingIds, $keep);
            if (! empty($toRemove)) {
                ProductVariant::destroy($toRemove);
            }
        }

        // 5) Sync product-level images
        if ($request->hasFile('images')) {
            // xóa cũ
            foreach ($product->images as $oldImg) {
                Storage::disk('public')->delete(str_replace('storage/','',$oldImg->image_url));
            }
            $product->images()->delete();
            // lưu mới
            foreach ($request->file('images') as $i => $file) {
                $p = $file->store('products','public');
                $product->images()->create([
                    'image_url'  => 'storage/'.$p,
                    'alt_text'   => "{$product->name} - ảnh ".($i+1),
                    'sort_order' => $i+1,
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success','Cập nhật sản phẩm thành công!');
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
