<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Nếu không có quyền, chuyển hướng về trang chính
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
