@extends('client.layout.master')

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>{{ $product->category->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ Storage::url($product->thumbnail->path) }}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        <p class="single-product-pricing">{{ number_format($product->price, 0, '.', '.') }}đ</p>
                        <div class="single-product-form">
                            <form action="#" method="post">
                                @csrf
                                <input type="number" placeholder="1" min="1">
                                <div>
                                    <button class="cart-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </form>
                            <p><strong>Danh mục: </strong>{{ $product->category->name }}</p>
                            <p>{{ $product->description }}</p>
                        </div>
                        <h4>Share:</h4>
                        <ul class="product-share">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

    <!-- more products -->
    <div class="more-products mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Sản phẩm</span> liên quan</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($productSuggest as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('product.detail', $product->slug) }}"><img
                                        src="{{ Storage::url($product->thumbnail->path) }}" alt=""></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price"> {{ number_format($product->price, 0, '.', '.') }} </p>
                            <a href="{{ route('cart') }}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to
                                Cart</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end more products -->
@endsection
