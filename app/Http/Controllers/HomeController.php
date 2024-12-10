<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
{
    $products = Product::all(); // Lấy danh sách sản phẩm
    return view('home', compact('products')); // Truyền dữ liệu sang view
}
}
