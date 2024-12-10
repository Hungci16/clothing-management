@extends('layouts.app')

@section('content')
    <h1>Thanh toán</h1>

    <h2>Thông tin đơn hàng</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng cộng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>  <!-- Hiển thị giá tiền với định dạng VND -->
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>  <!-- Hiển thị tổng cộng với định dạng VND -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Tổng cộng: {{ number_format($total, 0, ',', '.') }}</strong></p>  <!-- Hiển thị tổng cộng với VND -->

    <!-- Form thanh toán -->
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <h3>Thông tin giao hàng</h3>
        <div class="form-group">
            <label for="name">Tên người nhận:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div> 
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="number" id="phone" name="phone" class="form-control" required>
        </div> 
        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>                                                               

        <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Quay lại trang sản phẩm</a>
    
    </form>

@endsection
