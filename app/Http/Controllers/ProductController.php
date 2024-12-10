<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục từ cơ sở dữ liệu
        return view('products.create', compact('categories')); // Truyền $categories vào view
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[^\d]*$/'], // Không cho phép số trong tên
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'required|in:S,M,L,XL', // Chỉ chấp nhận các giá trị S, M, L, XL
            'color' => 'nullable|string|max:50',
            'product_code' => 'required|string|max:100|unique:products,product_code', // Mã sản phẩm không được trùng
        ], [
            'product_code.unique' => 'Mã sản phẩm đã tồn tại.',
            'name.regex' => 'Tên sản phẩm không được chứa số.',
        ]);

        // Lưu hình ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        // Tạo sản phẩm mới
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'size' => $request->size,      // Lưu size
            'color' => $request->color,    // Lưu color
            'product_code' => $request->product_code, // Lưu product_code
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm.');
    }

    // Hiển thị chi tiết sản phẩm
    public function showProductDetails($id)
    {
        $product = Product::with('transactions')->findOrFail($id);
        return view('products.details', compact('product'));
    }

    // Hiển thị form sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Lấy danh mục
        return view('products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[^\d]*$/'],
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'required|in:S,M,L,XL', // Chỉ chấp nhận các giá trị S, M, L, XL
            'color' => 'nullable|string|max:50',
            'product_code' => 'required|string|max:100|unique:products,product_code,' . $product->id, // Chấp nhận trùng với chính nó
        ], [
            'product_code.unique' => 'Mã sản phẩm đã tồn tại.',
            'name.regex' => 'Tên sản phẩm không được chứa số.',
        ]);

        // Cập nhật hình ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'size' => $request->size,      // Cập nhật size
            'color' => $request->color,    // Cập nhật color
            'product_code' => $request->product_code, // Cập nhật product_code
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}
