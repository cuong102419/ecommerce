@extends('client.layout.master')

@section('title')
    Đơn hàng
@endsection

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Đơn hàng của bạn</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <form action="{{ route('orders.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="checkout-accordion-wrap">
                            <div class="accordion">
                                <div class="card single-accordion">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Địa chỉ nhận hàng
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="billing-address-form">
                                                <p>
                                                    <input type="text" name="email" placeholder="Email"
                                                        value="{{ Auth::user()->email ?? '' }}">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </p>
                                                <p>
                                                    <input type="text" name="shipping_name" placeholder="Họ tên"
                                                        value="{{ Auth::user()->name ?? '' }}">
                                                    @error('shipping_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </p>
                                                <p>
                                                    <input type="text" name="shipping_address" placeholder="Địa chỉ">
                                                    @error('shipping_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </p>
                                                <p><input type="tel" name="shipping_phone" placeholder="Số điện thoại">
                                                    @error('shipping_phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </p>
                                                <p>
                                                    <textarea name="note" id="bill" cols="30" rows="10" placeholder="Ghi chú"></textarea>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="order-details-wrap">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody class="order-details-body">
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->product->price, 0, '.', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody class="checkout-details">
                                    <tr>
                                        <td colspan="2">Tổng giá</td>
                                        <td>{{ number_format($totalPrice, 0, '.', '.') }}đ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Vận chuyển</td>
                                        <td>{{ number_format(50000, 0, '.', '.') }}đ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h4>Thành tiền</h4>
                                        </td>
                                        <td>
                                            <h4 class="text-danger">{{ number_format($totalPrice + 50000, 0, '.', '.') }}đ
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mb-4 mt-3">
                                <div class="form-check d-flex align-items-center">
                                    <input required name="payment_method" id="cod" type="radio" class="form-radio"
                                        value="cod" checked>
                                    <label class="form-check mb-0" for="cod">Thanh toán khi nhận hàng</label>
                                </div>
                                <div class="form-check d-flex align-items-center mt-2">
                                    <input required name="payment_method" id="momo" type="radio" class="form-radio"
                                        value="momo">
                                    <label class="form-check mb-0" for="momo">Ví điện tử Momo</label>
                                </div>
                            </div>
                            <div><button type="submit" class="boxed-btn">Thanh toán</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
