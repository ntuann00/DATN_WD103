<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion; 

class DiscountController extends Controller
{
   
    public function index()
    {
        $discounts = Promotion::all(); 
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        Promotion::create($request->all()); 
        return redirect()->route('admin.discounts.index')->with('success', 'Thêm mã khuyến mãi thành công!');
    }

    public function edit($id)
    {
        $discount = Promotion::findOrFail($id); 
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, $id)
    {
        $discount = Promotion::findOrFail($id);
        $discount->update($request->all());
        return redirect()->route('admin.discounts.index')->with('success', 'Cập nhật mã khuyến mãi thành công!');
    }

    public function destroy($id)
    {
        $discount = Promotion::findOrFail($id);
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Xóa mã khuyến mãi thành công!');
    }
}
