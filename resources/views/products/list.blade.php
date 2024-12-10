<div class="row">
    @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Giá: </strong>{{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <a href="#" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
