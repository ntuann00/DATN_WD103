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
        $attributeValues = AttributeValue::paginate(5);
        return view('admin.attributeValues.index', compact('attributeValues'));
    }
    public function create()
    {
         $attributes = Attribute::all();
        return view('admin.attributeValues.create', compact('attributes'));
    }
    public function store(Request $request)
    { 
      $request->validate([
            'attribute_id' => 'required|numeric',
            'value' => 'required|string|max:255',
        ]);

        AttributeValue::create($request->all());
        return redirect()->route('attributeValues.index')->with('success', 'Thêm thành công!');

    }
    public function show($id)
    {
       $AttributeValue = AttributeValue::findOrFail($id);
       $attributes = Attribute::all();
        return view('admin.attributeValues.show', compact('AttributeValue','attributes'));
        
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
