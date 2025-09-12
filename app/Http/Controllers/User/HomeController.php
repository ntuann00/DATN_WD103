<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\Product;

use App\Models\Product_variant_value;
use App\Models\User;
use App\Models\Category;
<<<<<<< HEAD
=======
use App\Models\Refund;
use App\Models\Refund_info;
use App\Models\Order;
use App\Models\OrderDetail;
>>>>>>> origin/main
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
    public function index()
    {
        $FProducts = Product::with(['category', 'variants.values'])->orderBy('created_at', 'desc')->limit(8)->get();
        return view('user.index', compact('FProducts'));

        // $Products = Product::has('variants')
        //                    ->with('variants')
        //                    ->latest()       // order by created_at desc
        //                    ->take(12)        // ví dụ lấy 8 sản phẩm nổi bật
        //                    ->get();

        // $Categorys = Category::all();

        // return view('user.index', compact('Products','Categorys'));

    }

    public function brand()
    {
        return view('user.products.list-brand');
    }

    public function product()
    {
        // $Products = Product::paginate(10);
        // Eager‐load relation 'variants' để có thể dùng $product->variants->first() trong view
        $Products = Product::has('variants')
            ->with('variants')
            ->paginate(10);  
        return view('user.products.list-product', compact('Products'));
    }


    public function new_product()
    {
        $Products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('user.products.list-product', compact('Products'));
    }

    public function product_detail($id)
    {
        // Lấy sản phẩm + biến thể + giá trị thuộc tính
        $Product = Product::with([
            'images',
            'variants.attributeValues.attribute'
        ])->findOrFail($id);


        // Gợi ý 4 sản phẩm khác
        $Related = Product::has('variants')
            ->with('variants.attributeValues.attribute')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Tạo nhóm thuộc tính từ tất cả các variants
        $attributeGroups = [];
        $attributeQuantity = [];

        foreach ($Product->variants as $variant) {
            $attributeCombinationAB = '';
            $attributeCombinationBA = '';

            foreach ($variant->attributeValues as $attrValue) {
                $attrName = $attrValue->attribute->name;
                $attributeGroups[$attrName][$attrValue->id] = $attrValue;

                $attributeCombinationAB .= $attrValue->value . '-';
                $attributeCombinationBA = $attrValue->value . '-' . $attributeCombinationBA;
            }

            $attributeQuantity[$attributeCombinationAB] = $variant->quantity;
            $attributeQuantity[$attributeCombinationBA] = $variant->quantity;
        }

        $countAttribute = count($attributeGroups);

        return view('user.products.product-detail', compact([
            'Product',
            'Related',
            'variant',
            'attributeGroups',
            'attributeQuantity',
            'countAttribute'
        ]));
    }



    public function category_product($id)
    {
        $Products = Product::all()->where('category_id', $id);
        return view('user.products.list-product', compact('Products'));
    }

<<<<<<< HEAD
=======

    public function purchasehistory(){
        $userId = auth()->id(); // user id
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

    public function refund($id)
    {
        // id đang lấy là order id. cần order detail
        $det_id = DB::table('order_details')->where('id',$id)->value('order_id');
        $id_pro_det = DB::table('order_details')->where('id',$id)->value('product_id');
        // $det_id= OrderDetail::pluck('order_id');
        // $id_pro_det= OrderDetail::pluck('product_id');
        // orderdetail
        $Detail = OrderDetail::find($det_id);
        $Order = Order::find($id);
        $Product = Product::where('id', $id_pro_det)->first();
        // dd($Detail,$Product);
        return view('user.users.refund',compact('Detail','Product','Order'));
    }

    public function save_refund(Request $request,$id){
        $userId = auth()->id(); // user id

        $validated = $request->validate([
            'reason'      => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $validated['user_id'] = $userId;
        $validated['order_id'] = $id;
        // Refund::create($validated);

        $refund = Refund::create($validated);

        $validatedInfo = $request->validate([
        'bank'        => 'nullable|string|max:255',
        'bank_number' => 'nullable|string|max:255',
        'bank_holder' => 'nullable|string|max:255',
        ]);
        $validatedInfo['refund_id'] = $refund->id;

        Refund_info::create($validatedInfo);

        return redirect()->route('refund',$id)->with('success', 'Gửi yêu cầu thành công!');
        // dd($userId,$reason,$description,$stk,$bank,$holder_name,$id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm mới thành công!');
    }

>>>>>>> origin/main
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
