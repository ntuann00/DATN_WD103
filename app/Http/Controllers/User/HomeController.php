<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_variant_value;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeController extends BaseController
{


    public function search(Request $request){
        $keyword = $request->input('keyword');
        $Products = Product::where('name', 'like', "%{$keyword}%") ->get();
        return view('user.products.list-product',compact('Products'));
    }

    public function index(){
        $FProducts = Product::with(['category', 'variants.values'])->orderBy('created_at', 'desc')->limit(8)->get();
        return view('user.index', compact('FProducts'));
    }

    public function brand(){
        return view('user.products.list-brand');
    }

    public function product(){
        $Products = Product::paginate(20);
        // Eager‐load relation 'variants' để có thể dùng $product->variants->first() trong view
        $Products = Product::has('variants')
                           ->with('variants')
                           ->get();
        
        return view('user.products.list-product',compact('Products'));
    }


    public function new_product(){
        $FProducts=Product::orderBy('created_at', 'desc')->paginate(20);
        return view('user.products.list-product',compact('Products'));
        $Products = Product::has('variants')
                           ->with('variants')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);

        return view('user.products.list-product', compact('Products'));
    }

    public function product_detail($id){
        $Product = Product::with('variants')->findOrFail($id);

        // Lấy thêm 4 sản phẩm ngẫu nhiên (có variant) để gợi ý nếu bạn muốn
        $Related = Product::has('variants')
                          ->with('variants')
                          ->where('id', '!=', $id)
                          ->inRandomOrder()
                          ->take(4)
                          ->get();

        return view('user.products.product-detail', compact('Product','Related'));
    }

    public function category_product($id){
        $Products = Product::all()->where('category_id', $id);
        return view('user.products.list-product', compact('Products'));
    }

    public function account(){
        return view('user.pages.my_account');
    }
    public function cart(){
        return view('user.cart.cart');
    }
    public function login(){
        return view('user.auth.login');
    }
    public function register(){
        return view('user.auth.register');
    }
    public function checkout(){
        return view('user.pages.checkout_page');
    }
    public function about_us(){
        return view('user.pages.about_us');
    }
    public function blog(){
        return view('user.pages.blog');
    }
    public function blog_detail(){
        return view('user.pages.blog_detail');
    }
    public function contact(){
        return view('user.pages.contact');
    }
    public function faq(){
        return view('user.pages.faq');
    }
}
