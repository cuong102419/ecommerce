@extends('client.layout.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Chi tiết đơn hàng</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <div class="detail-order-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div class="border p-3">
                        <div>
                            <span class="d-block mb-3">Trạng thái:</span>
                            <h3 class="text-uppercase text-{{ $statuses[$order->status]['color'] }}">
                                {{ $statuses[$order->status]['label'] }}</h3>
                        </div>
                        <div class="mt-5">
                            <table class="table">
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <img src="{{ Storage::url($item->product_image) }}" width="100"
                                                        alt="">
                                                </div>
                                                <div class="p-3">
                                                    <h4>{{ $item->product_name }}</h4>
                                                    <span>{{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <h4>CHI TIẾT ĐƠN HÀNG</h4>
                    <div>
                        <table class="table">
                            <tr>
                                <th>
                                    <span class="d-block">Mã đơn hàng:</span>
                                    <span class="d-block">Ngày tạo:</span>
                                </th>
                                <th class="text-end">
                                    <span class="d-block">{{ $order->id }}</span>
                                    <span class="d-block">{{ $order->created_at->format('d-m-Y') }}</span>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Thông tin giao hàng</h5>
                                    <span class="d-block">{{ $order->shipping_name }}</span>
                                    <span class="d-block">{{ $order->shipping_phone }}</span>
                                    <span class="d-block">{{ $order->email }}</span>
                                    <span class="d-block">{{ $order->shipping_address }}</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Phương thức</h5>
                                    <span
                                        class="d-block">{{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Ví điện tử Momo' }}</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="d-block">{{ $order->orderItems->count() }} mặt hàng:</span>
                                    <span class="d-block">Giao hàng:</span>
                                    <h4 class="d-block mt-4">Tổng:</h4>
                                </td>
                                <td>
                                    <span
                                        class="d-block">{{ number_format($order->orderItems->sum('unit_price'), 0, '.', '.') }}đ</span>
                                    <span class="d-block">50.000đ</span>
                                    <h4 class="d-block text-danger mt-4">
                                        {{ number_format($order->total_amount, 0, '.', '.') }}đ
                                    </h4>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
