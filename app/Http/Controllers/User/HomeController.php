<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_variant_value;
use App\Models\Users;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeController extends BaseController
{
    

    public function index(){
        
        $Products = Product::all();
        return view('user.index', compact('Products'));
        // return view('user.index');
    }
    public function product(){
        
        $Products = Product::all();
        return view('user.products.list-product', compact('Products'));
    }
    public function product_detail(){
        
        $Products = Product::all();
        return view('user.products.product-detail', compact('Products'));
    }

}
