@extends('client.layout.master')

@section('title', 'Sản phẩm')

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Sản phẩm</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- products -->
    <div class="product-section mt-80 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <form action="{{ route('product.list') }}" method="get">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <div class="w-25">
                                        <label for="" class="form-label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" name="keyword" placeholder="Nhập tên sản phẩm">
                                    </div>
                                    <div class="w-25">
                                        <label for="" class="form-label">Giá</label>
                                        <select name="sort" class="form-control" id="">
                                            <option selected value="">Tất cả</option>
                                           <option {{ request('sort') === 'price-asc' ? 'selected' : '' }} value="price-asc">Thấp đến cao</option>
                                           <option {{ request('sort') === 'price-desc' ? 'selected' : '' }} value="price-desc">Cao đến thấp</option>
                                        </select>
                                    </div>
                                    <div class="w-25">
                                        <label for="" class="form-label">Danh mục</label>
                                        <select name="category" class="form-control" id="">
                                            <option value=""
                                                {{ !request('category') == 'all' ? 'selected' : '' }}>Tất
                                                cả
                                            </option>
                                            @foreach ($categories as $category)
                                                <option {{ request('category') === $category->id ? 'selected' : '' }}
                                                    value="{{ $category->slug }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn cart-btn"><i class='bx bx-search-alt-2' ></i> Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row product-lists">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('product.detail', $product->slug) }}"><img
                                        src="{{ Storage::url($product->thumbnail->path) ?? '' }}" alt=""></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price"> {{ number_format($product->price, 0, '.', '.') }}đ </p>
                            <a href="{{ route('product.detail', $product->slug) }}" class="cart-btn"><i
                                    class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $products->links('client.layout.partials.pagination-custom') }}
        </div>
    </div>
    <!-- end products -->
@endsection
