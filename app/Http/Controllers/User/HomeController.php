<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_variant_value;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
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


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $Products = Product::where('name', 'like', "%{$keyword}%")->get();
        return view('user.products.list-product', compact('Products'));
    }

    // public function index(){
    //     $FProducts=Product::orderBy('created_at', 'desc')->paginate(8);
    //     $Fcate=Category::all();
    //     return view('user.index', compact('FProducts','Fcate'));

    // }

    public function index(){
        $FProducts = Product::with(['category', 'variants'])->latest()->take(8)->get();
        $Tsell=Product::with(['category', 'variants'])->inRandomOrder()->take(8)->get();
        $Cate=Category::inRandomOrder()->take(6)->get();

        return view('user.index', compact('FProducts','Tsell','Cate'));
    }

    public function brand()
    {
        return view('user.products.list-brand');
    }


    public function product()
    {
        $Products = Product::paginate(20);
        // Eager‐load relation 'variants' để có thể dùng $product->variants->first() trong view
        $Products = Product::has('variants')
            ->with('variants')
            ->get();
        return view('user.products.list-product', compact('Products'));
    }


    public function new_product()
    {
        $Products = Product::orderBy('created_at', 'desc')->paginate(20);
        return view('user.products.list-product', compact('Products'));

    }

   public function product_detail($id)
{
    // Lấy sản phẩm + biến thể + giá trị thuộc tính
    $Product = Product::with([
        'variants.attributeValues.attribute'
    ])->findOrFail($id);

    $variant = $Product->variants->first();

    // Gợi ý 4 sản phẩm khác
    $Related = Product::has('variants')
        ->with('variants.attributeValues.attribute')
        ->where('id', '!=', $id)
        ->inRandomOrder()
        ->take(4)
        ->get();

    // Tạo nhóm thuộc tính từ tất cả các variants
    $attributeGroups = [];

    foreach ($Product->variants as $variant) {
        foreach ($variant->attributeValues as $attrValue) {
            $attrName = $attrValue->attribute->name;
            $attributeGroups[$attrName][$attrValue->id] = $attrValue; // gán object AttributeValue
        }
    }

    return view('user.products.product-detail', compact('Product', 'Related', 'variant', 'attributeGroups'));
}



    public function category_product($id)
    {
        $Products = Product::all()->where('category_id', $id);
        return view('user.products.list-product', compact('Products'));
    }


    public function purchasehistory(){
        $userId = auth()->id(); // user id
        // $orderId = Order::where('user_id', "{$userId}")->value('id') ; // order id của user
        // $orderDetailId = OrderDetail::where('id', "{$orderId}")->value('product_id') ; // lấy id sản phẩm và số lượng từ orderdetail theo id order
        // $BProducts = product::where('id', "{$orderDetailId}")->get(); // lấy ra sản phẩm của orderdetail

        // Lấy tất cả đơn hàng của user
        $orders = Order::where('user_id', $userId)->get();
        // Lấy danh sách order_id từ các đơn hàng
        $orderIds = $orders->pluck('id');
        // Lấy chi tiết đơn hàng
        $orderDetails = OrderDetail::whereIn('order_id', $orderIds)->get();
        // Lấy product_id từ orderDetails
        $productIds = $orderDetails->pluck('product_id')->unique();
        $variantIds = $orderDetails->pluck('variant_id')->unique();

        // Lấy thông tin sản phẩm và biến thể
        $products = Product::whereIn('id', $productIds)->get();
        $variants = Product_variant::whereIn('id', $variantIds)->get();

        return view('user.users.purchasehistory', compact('orders', 'orderDetails', 'products','variants'));
    }   

    public function account()
    {
        return view('user.pages.my_account');
    }
    public function cart()
    {
        return view('user.cart.cart');
    }
    public function login()
    {
        return view('user.auth.login');
    }
    public function register()
    {
        return view('user.auth.register');
    }
    public function checkout()
    {
        return view('user.pages.checkout_page');
    }
    public function about_us()
    {
        return view('user.pages.about_us');
    }
    public function blog()
    {
        return view('user.pages.blog');
    }
    public function blog_detail()
    {
        return view('user.pages.blog_detail');
    }
    public function contact()
    {
        return view('user.pages.contact');
    }
    public function faq()
    {
        return view('user.pages.faq');
    }
}
