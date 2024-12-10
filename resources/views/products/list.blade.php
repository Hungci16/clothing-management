<div class="row">
    @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Giá: </strong>{{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <!-- Nút xem chi tiết -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>

                    <!-- Nút thêm vào giỏ hàng -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" class="form-control mt-2" style="width: 80px;">
                        <button type="submit" class="btn btn-success mt-2">Thêm vào giỏ</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
