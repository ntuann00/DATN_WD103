<?php
namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Gửi dữ liệu tới view header
        View::composer('*', function ($view) {
            $view->with([
                'Hproducts' => Product::orderBy('created_at', 'desc')->limit(20)->get(),
                'HCategories' => Category::all(),
                'HCarts' => Cart::all(),
                'HUsers' => User::all(),
            ]);
        });
    }

    public function register()
    {
        //
    }

    public function showcart(){
        if (Auth::check()) {
        // Người dùng đã đăng nhập
        $user = Auth::user();
        $cartItems = Cart::with('product') // lấy thông tin sản phẩm kèm theo
            ->where('user_id', $user->id)
            ->get();
             return view('*', compact('cartItems'));
        } else {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng');
        }
    }
}
?>
