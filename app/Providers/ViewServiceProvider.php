<?php
namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
}
?>
