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
        $Categorys = Category::all();
        return view('user.index', compact('Products','Categorys'));
        // return view('user.index');
    }

    public function brand(){
        return view('user.products.list-brand');
    }

    public function product(){
        $Products = Product::paginate(20);
        // var_dump($Products);
        return view('user.products.list-product', compact('Products'));

    }
    public function product_detail($id){
        $Products = Product::paginate(4);
        $Product = Product::findOrFail($id);
        return view('user.products.product-detail', compact('Product','Products'));
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
