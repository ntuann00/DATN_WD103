<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleHasAdmins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (
            Auth::check() && (
                Auth::user()->role->name === 'admin' 
            ) &&
            Auth::user()->status == 1
        ) {
            return $next($request);
        }

        return abort(403, 'Bạn không có quyền truy cập vào hệ thống.');
    }
}
