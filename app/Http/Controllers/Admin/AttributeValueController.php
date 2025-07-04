<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AttributeValueController extends BaseController
{

    public function index()
    {
        $attributeValues = AttributeValue::latest()->paginate(5);
        return view('admin.attributeValues.index', compact('attributeValues'));
    }
    public function create(Request $request)
    {
       $attribute_id = $request->query('attribute_id'); // lấy từ URL
   $attributes = Attribute::all();
        return view('admin.attributeValues.create', compact('attributes', 'attribute_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|numeric',
            'value' => 'required|string|max:255',
        ]);

        AttributeValue::create($request->all());
        return redirect()->route('attributes.index')->with('success', 'Thêm thành công!');
    }
    public function show($id)
    {
        $AttributeValue = AttributeValue::findOrFail($id);
        $attributes = Attribute::all();
        return view('admin.attributeValues.show', compact('AttributeValue', 'attributes'));
    }

    public function edit($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributes = Attribute::all();
        return view('admin.attributeValues.edit', compact('attributeValue', 'attributes'));
    }
public function update(Request $request)
{
    $data = $request->input('values'); // Lấy toàn bộ input values

    foreach ($data as $item) {
        AttributeValue::where('id', $item['id'])->update([
            'value' => $item['value']
        ]);
    }

    return redirect()->route('attributes.index')->with('success', 'Cập nhật thành công!');
}
    public function destroy($id)
    {
        $attributeValues = AttributeValue::findOrFail($id);
        $attributeValues->delete();

        return redirect()->route('attributeValues.index')->with('success', 'Xóa thành công!');
    }
}
