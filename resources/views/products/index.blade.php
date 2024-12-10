@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Quản lý sản phẩm</h1>

        {{-- Hiển thị thông báo thành công hoặc lỗi --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Nút thêm sản phẩm mới --}}
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">Thêm sản phẩm mới</a>

        <!-- {{-- Bao gồm danh sách sản phẩm chung --}}
        @include('products.list', ['products' => $products])  -->

        {{-- Hiển thị bảng chi tiết sản phẩm --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Size</th>
                    <th>Màu</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng trong kho</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $product->color }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/100' }}" width="100" alt="{{ $product->name }}">
                        </td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            {{-- Hành động: Sửa, Xóa --}}
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>

                            {{-- Form thêm sản phẩm vào giỏ hàng --}}
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <label for="quantity-{{ $product->id }}">Số lượng:</label>
                                <input type="number" name="quantity" id="quantity-{{ $product->id }}" value="1" min="1" class="form-control mb-2" style="width: 80px; display:inline-block;">
                                <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
