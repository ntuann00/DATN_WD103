<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController
{
 
    public function index()
    {
        $categories = Category::paginate(3);
        return view('admin.categories.index', compact('categories'));
    }
     public function create()
    {
      return view('admin.categories.create');
    }
     public function store(Request $request)
    {{
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Thêm mới thành công!');
    }
    
    }

 public function edit()
    {
      
    }

 public function update()
    {

    }
    public function destroy()
    {
  
    }
}



