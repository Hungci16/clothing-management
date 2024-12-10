@extends('layouts.app') <!-- Sử dụng layout giao diện người dùng -->

@section('content')
    <div class="container">
        @if($product)
            <h1 class="my-4">{{ $product->name }}</h1>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" class="img-fluid" alt="{{ $product->name }}">
                </div>
                <div class="col-md-6">
                    <h3>Thông tin sản phẩm</h3>
                    <p><strong>Mã sản phẩm:</strong> {{ $product->product_code }}</p>
                    <p><strong>Kích cỡ:</strong> {{ $product->size }}</p>
                    <p><strong>Màu sắc:</strong> {{ $product->color }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <p><strong>Mô tả:</strong> {{ $product->description }}</p>
                    <p><strong>Số lượng trong kho:</strong> {{ $product->stock }}</p>
                    <a href="/" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        @else
            <p>Sản phẩm không tồn tại.</p>
        @endif
    </div>
@endsection
