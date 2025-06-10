<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
      
    }
     public function store()
    {
    
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



