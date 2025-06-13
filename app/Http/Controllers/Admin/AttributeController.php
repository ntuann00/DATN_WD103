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
         $attributes = Attribute::latest()->paginate(3);
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

            return redirect()->route('attributeValues.index')->with('success', 'Thêm mới thành công!');
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
