<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Models\Transaction;
use App\Models\Product;


Route::get('/', function () {
    return redirect()->route('login');
});

// Trang đăng nhập
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Trang đăng ký
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Nhóm các route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::resource('products', ProductController::class);
    Route::get('/admin/products', [AdminController::class, 'index'])->name('admin.products.index'); // Admin
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{productId}', [ProductController::class, 'show'])->name('reports.products');
    Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');

        

    Route::get('customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customers_create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customers_store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customers_edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customers_update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customers_destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

    // Nhóm route chỉ dành cho admin
    // Route::middleware(['role:admin'])->group(function () {
    //     Route::resource('users', UserController::class);
    // });

    // Trang admin
    Route::middleware('auth:web')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Trang khách hàng
    Route::middleware('auth:customer')->group(function () {
        Route::get('/', function () {
            return view('home'); // File home.blade.php
        });

        // Route::get('/cart', function () {
        //     return 'Your Cart';
        // })->name('cart');
    });
    //promotion
    Route::resource('promotions', PromotionController::class);

    Route::prefix('orders')->name('orders.')->group(function () {
        // Hiển thị danh sách đơn hàng
        Route::get('/', [OrderController::class, 'index'])->name('index');

        // Xem chi tiết đơn hàng
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');

        // Cập nhật trạng thái đơn hàng
        Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');

        // In hóa đơn PDF
        Route::get('/{id}/invoice', [OrderController::class, 'printInvoice'])->name('printInvoice');
    });


    // Báo cáo doanh thu
    Route::get('/reports/revenue', [ReportController::class, 'revenueReport'])->name('reports.revenue');

    // Báo cáo sản phẩm bán chạy
    Route::get('/reports/products', [ReportController::class, 'productReport'])->name('reports.products');
});
Route::middleware(['web'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');


// Route::resource('orders', OrderController::class);
// Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
// Route::get('orders/{id}/invoice', [OrderController::class, 'printInvoice'])->name('orders.printInvoice');
Route::get('/', function () {
    return view('home'); // File home.blade.php
});

Route::get('/product', function () {
    return view('product');  
});
Route::get('/login', function () {
    return view('login');  
});
Route::get('/createaccount', function () {
    return view('createaccount');  
});
Route::get('/contact', function () {
    return view('contact');  
});
Route::get('/blog', function () {
    return view('blog');  
});
Route::get('/about', function () {
    return view('about');  
});
Route::get('/productItem', function () {
    return view('productItem');  
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/transactions/{id}', function ($id) {
    // Tìm giao dịch
    $transaction = Transaction::findOrFail($id);

    // Lấy danh sách sản phẩm liên quan
    $products = $transaction->products;

    // Trả về view với dữ liệu
    return view('transactions.show', [
        'transaction' => $transaction,
        'products' => $products,
    ]);
    Route::get('/products/{id}/transaction', [TransactionController::class, 'showTransaction'])->name('products.transaction');

});
Route::get('/products/{id}/transaction', function ($id) {
    $product = Product::findOrFail($id);
    $transaction = $product->transaction;

    return view('products.transaction', compact('product', 'transaction'));
});
