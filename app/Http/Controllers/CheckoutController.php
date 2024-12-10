<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart; // Giả sử bạn đang dùng thư viện Cart
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();

        return view('checkout.index', compact('cartItems', 'total'));
    }

    // Xử lý thanh toán
    public function process(Request $request)
    {
        $cartItems = Cart::getContent();
    
        foreach ($cartItems as $item) {
            $product = Product::find($item->id);
    
            // Kiểm tra tồn kho
            if ($product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Sản phẩm {$product->name} không đủ hàng.");
            }
    
            // Trừ số lượng trong kho
            $product->stock -= $item->quantity;
            $product->save();
        }
    
        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => Cart::getTotal(),
        ]);
    
        // Lưu các sản phẩm trong đơn hàng
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }
    
        // Xóa giỏ hàng sau khi thanh toán
        Cart::clear();
    
        return redirect()->route('products.index')->with('success', 'Thanh toán thành công!');
    }
    
}
