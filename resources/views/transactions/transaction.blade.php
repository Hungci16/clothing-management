@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông tin sản phẩm</h1>
        <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>

        <h2>Thông tin giao dịch</h2>
        @if ($transaction)
            <p><strong>ID Giao dịch:</strong> {{ $transaction->id }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($transaction->total, 0, ',', '.') }} VND</p>
        @else
            <p>Không có giao dịch liên quan đến sản phẩm này.</p>
        @endif
    </div>
@endsection
