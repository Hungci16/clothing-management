<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function showProduct($id)
    {
        // Tìm giao dịch
        $transaction = Transaction::findOrFail($id);

        // Lấy sản phẩm liên quan
        $product = $transaction->product;

        // Trả về view và truyền dữ liệu
        return view('transactions.product', compact('transaction', 'product'));
    }
}
