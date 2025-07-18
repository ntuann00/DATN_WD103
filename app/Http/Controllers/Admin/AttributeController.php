<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AttributeController extends BaseController
{
    public function index()
    {
        $attributes = Attribute::with('values')->withCount('values')->latest()->paginate(3);
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

        return redirect()->route('admin.attributes.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute->update($request->only('name'));

        return redirect()->route('admin.attributes.index')->with('success', 'Cập nhật thành công!');
    }

    public function show($id)
    {
        $attribute = Attribute::with('values')->findOrFail($id);
        return view('admin.attributes.show', compact('attribute'));
    }
}
