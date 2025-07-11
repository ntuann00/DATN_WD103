<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Category;
use App\Models\Product;

class AutoRunFunction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $this->header();
        return $next($request);
    }

    public function header(){
        $HCategories = Category::all();
        $HProducts = Product::all();
        return compact('HCategories');
        // echo '<pre>' , var_dump($HCategories) , '</pre>';
    }
}
