@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giỏ hàng</title>
        <!-- Thêm link tới CSS của Bootstrap -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
        <h1>Giỏ hàng của bạn</h1>

        @if ($cartItems->isEmpty())
            <p>Giỏ hàng của bạn hiện đang trống.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng cộng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}</td>  <!-- Hiển thị giá tiền VND -->
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>  <!-- Tổng cộng VND -->
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Tổng cộng: {{ number_format(Cart::getTotal(), 0, ',', '.') }}</strong></p>  <!-- Tổng giỏ hàng với VND -->
        @endif

        <a href="{{ route('checkout.index') }}" class="btn btn-success">Tiến hành thanh toán</a>
        </div>

        <!-- Thêm script của Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
@endsection