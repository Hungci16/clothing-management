@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông tin giao dịch</h1>
        <p><strong>ID Giao dịch:</strong> {{ $transaction->id }}</p>
        <p><strong>Ngày:</strong> {{ $transaction->created_at }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($transaction->total, 0, ',', '.') }} VND</p>

        <h2>Sản phẩm trong giao dịch</h2>
        <ul>
            @foreach ($products as $product)
                <li>{{ $product->name }} - {{ number_format($product->price, 0, ',', '.') }} VND</li>
            @endforeach
        </ul>
    </div>
@endsection
