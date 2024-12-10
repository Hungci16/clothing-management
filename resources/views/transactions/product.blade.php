@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông tin giao dịch</h1>
        <p><strong>ID Giao dịch:</strong> {{ $transaction->id }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($transaction->total, 0, ',', '.') }} VND</p>

        <h2>Thông tin sản phẩm</h2>
        <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>
        <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND</p>
    </div>
@endsection
