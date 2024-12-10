<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product
use Darryldecode\Cart\Facades\CartFacade as Cart; // Import Cart facade


class CartController extends Controller
{
    // Phương thức thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
{
    // Tìm sản phẩm theo ID
    $product = Product::find($id);

    if ($product) {
        $quantity = $request->input('quantity', 1); // Lấy số lượng từ form

        // Kiểm tra số lượng hàng trong kho
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Số lượng hàng trong kho không đủ.');
        }

        // Thêm sản phẩm vào giỏ hàng
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        // Cập nhật lại số lượng trong kho (nếu cần)
        $product->stock -= $quantity;
        $product->save();

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    return redirect()->back()->with('error', 'Số lượng hàng trong kho không đủ.');
}

    public function showCart()
    {
        $cartItems = Cart::getContent(); // Lấy nội dung giỏ hàng
        return view('cart.index', compact('cartItems')); // Trả về view giỏ hàng
    }

    public function updateCart(Request $request, $id)
    {
        // Lấy sản phẩm trong giỏ hàng
        $item = Cart::get($id);

        if (!$item) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        // Lấy sản phẩm từ cơ sở dữ liệu
        $product = Product::find($item->id);

        if ($product) {
            // Kiểm tra số lượng yêu cầu có hợp lệ không (số lượng yêu cầu không vượt quá số lượng trong kho)
            $newQuantity = $request->input('quantity');

            if ($newQuantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'Số lượng yêu cầu vượt quá số lượng trong kho.');
            }

            // Cập nhật lại số lượng trong giỏ hàng
            Cart::update($id, [
                'quantity' => $newQuantity
            ]);

            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
        }

        return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại.');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        // Lấy thông tin sản phẩm trong giỏ hàng
        $item = Cart::get($id);

        if (!$item) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = Product::find($item->id);

        if ($product) {
            // Khôi phục số lượng vào kho
            $product->stock += $item->quantity;
            $product->save();
        }

        // Xóa sản phẩm khỏi giỏ hàng
        Cart::remove($id);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng và số lượng trong kho đã được khôi phục.');
    }   
    public function add(Request $request, $productId)
    {
        $product = Product::find($productId);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
    
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => 1, // Mặc định số lượng là 1
            'price' => $product->price,
        ]);
    
        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }
    
    

}
