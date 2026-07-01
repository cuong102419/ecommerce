@extends('client.layout.master')

@section('title')
    Danh sách đơn hàng
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

    <div class="order-section mt-150 mb-150">
        <div class="container">
            @foreach ($orders as $order)
                <a href="{{ route('orders.detail', $order->id) }}">
                    <div class="border p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="fw-bold">
                                    Mã đơn: {{ $order->id }}
                                </h5>
                                <h5>
                                    Thành tiền: <span class="text-danger">{{ number_format($order->total_amount, 0, '.', '.') }}đ</span>
                                </h5>
                                <span>Phương thức thanh toán: {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Ví điện tử Momo' }}</span>
                                <div>
                                    <span class="text-dark d-block"></span>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-{{ $statuses[$order->status]['color'] }}">{{ $statuses[$order->status]['label'] }}</h5>
                            </div>
                            <div>
                                <span class="mb-2">Ngày tạo: {{ $order->created_at->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
@endsection
