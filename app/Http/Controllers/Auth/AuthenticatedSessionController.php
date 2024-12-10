<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('login'); // Tạo view đăng nhập
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu yêu cầu
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cố gắng đăng nhập người dùng
        if (Auth::attempt($request->only('email', 'password'))) {
            // Nếu thành công, chuyển hướng đến trang đã được chỉ định
            return redirect()->intended('/categories' );
        }


         // Nếu không tìm thấy trong `users`, kiểm tra trong `customers`
         if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return redirect('/home'); // Trang khách hàng
        }
        
        // Nếu xác thực thất bại, chuyển hướng về với thông báo lỗi
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Đăng xuất người dùng khỏi ứng dụng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Đăng xuất người dùng
        Auth::logout();

        // Chuyển hướng đến trang đăng nhập
        return redirect('/login');
    }
}
