<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    $products = Product::all(); // Lấy danh sách sản phẩm
    return view('products.index', [
        'products' => $products,
        'isAdmin' => true, // Đánh dấu đây là trang admin
    ]);
}

}
