<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion; // đảm bảo bạn có model Promotion

class PromotionController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all(); // lấy toàn bộ bản ghi
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        Promotion::create($request->all());
        return redirect()->route('admin.promotions.index')->with('success', 'Thêm mã giảm giá thành công!');
    }

   public function edit($id)
{
    $promotion = Promotion::findOrFail($id);
    return view('admin.promotions.edit', compact('promotion'));
}


    public function update(Request $request, $id)
    {
        $Promotion = Promotion::findOrFail($id);
        $Promotion->update($request->all());
        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $Promotion = Promotion::findOrFail($id);
        $Promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Xóa thành công!');
    }
}
