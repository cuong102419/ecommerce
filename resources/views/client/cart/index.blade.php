@extends('client.layout.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Giỏ hàng</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            @if ($cartItems->isNotEmpty())
                <form action="{{ route('cart.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="cart-table-wrap">
                                <table class="cart-table">
                                    <thead class="cart-table-head">
                                        <tr class="table-head-row">
                                            <th class="product-remove"></th>
                                            <th class="product-image">Ảnh</th>
                                            <th class="product-name">Tên sản phẩm</th>
                                            <th class="product-price">Giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr class="table-body-row">
                                                <td class="product-remove">
                                                    <button class="btn" onclick="deleteItem({{ $item->id }})"><i
                                                            class="far fa-window-close"></i></button>
                                                </td>
                                                <td class="product-image"><img
                                                        src="{{ Storage::url($item->product->thumbnail->path) }}"
                                                        alt=""></td>
                                                <td class="product-name">{{ $item->product->name }}</td>
                                                <td class="product-price">
                                                    {{ number_format($item->product->price, 0, '.', '.') }}đ</td>
                                                <td class="product-quantity"><input type="number" min="1" required name="quantities[{{ $item->id }}]"
                                                        value="{{ $item->quantity }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="total-section">
                                <table class="total-table">
                                    <thead class="total-table-head">
                                        <tr class="table-total-row">
                                            <th>Tổng</th>
                                            <th>Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="total-data">
                                            <td><strong>Tổng tiền: </strong></td>
                                            <td>{{ number_format($totalPrice, 0, '.', '.') }}đ</td>
                                        </tr>
                                        <tr class="total-data">
                                            <td><strong>Vận chuyển: </strong></td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr class="total-data">
                                            <td><strong>Thành tiền: </strong></td>
                                            <td>{{ number_format($totalPrice + 50000, 0, '.', '.') }}đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="cart-buttons">
                                    <button class="btn btn-lg rounded-pill text-light" style="background-color: #F28123" type="submit">Cập nhật giỏ hàng</button>
                                    <a href="checkout.html" class="boxed-btn black">Thanh toán</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <h4 class="text-center">Giỏ hàng của bạn đang trống</h4>
            @endif
        </div>
    </div>
    <!-- end cart -->

    <form id="delete-form" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function deleteItem(id) {
            const form = document.getElementById('delete-form');
            form.action = `/cart/${id}`;
            form.submit();
        }
    </script>
@endsection
