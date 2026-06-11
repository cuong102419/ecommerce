@extends('client.layout.master')

@section('title')
    {{ $product->name }}
@endsection

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
                        <img src="{{ Storage::url($product->thumbnail->path) ?? '' }}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        <p class="single-product-pricing">{{ number_format($product->price, 0, '.', '.') }}đ</p>
                        <div class="single-product-form">
                            <form class="mb-5" action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" required>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div>
                                    <button class="cart-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </form>
                            <p><strong>Số lượng: </strong>{{ $product->stock }}</p>
                            <p><strong>Danh mục: </strong>{{ $product->category->name }}</p>
                            <p>{!! $product->description !!}</p>
                            <p>⚠️ Lưu ý Không dùng cho người dị ứng với thành phần của sản phẩm;</p>

                            Không sử dụng sản phẩm khi quá hạn sử dụng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

    <div class="mt-100 mb-150">
        <div class="container">
            <div class="comments-list-wrap">
                @if ($reviews->isEmpty())
                    <h3 class="comment-count-title">Chưa có đánh giá nào</h3>
                @else
                    @foreach ($reviews as $review)
                        <div class="comment-list">
                            <div class="single-comment-body">
                                <div class="comment-user-avater">
                                    <img src="{{ asset('assets-client/img/user.jpg') }}" alt="">
                                </div>
                                <div class="comment-text-body">
                                    <h4>{{ $review->user->name }} <span class="comment-date">{{ $review->created_at->format('d-m-Y') }}</span></h4>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if (Auth::check() && $hasBought && !$hasReviewed)
                <div class="comment-template">
                    <h4>Cảm nhận của bạn về sản phẩm</h4>
                    <p>Đánh giá của bạn giúp chúng tôi cải thiện sản phẩm tốt hơn.</p>
                    <form action="{{ route('review.store', $product->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="rating text-warning" style="cursor: pointer; font-size: 24px;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star" id="star-{{ $i }}"
                                        onclick="setRating({{ $i }})"></i>
                                @endfor
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                                @error('rating')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <p>
                            @error('comment')
                            <p class="text-danger mt-3">{{ $message }}</p>
                        @enderror
                        <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Để lại ý kiến của bạn tại đây"></textarea>
                        </p>
                        <p><button type="submit" class="cart-btn">Gửi</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

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
                                        src="{{ Storage::url($product->thumbnail->path) ?? '' }}" alt=""></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price"> {{ number_format($product->price, 0, '.', '.') }} </p>
                            <a href="{{ route('cart') }}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Thêm vào
                                giỏ hàng</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end more products -->

    <script>
        function setRating(rating) {
            document.getElementById('ratingInput').value = rating;

            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                if (i <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            }
        }
    </script>
@endsection
