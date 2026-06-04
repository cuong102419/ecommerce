@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">Table Basic</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Thanh toán</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $key }}</td>
                                <td>{{ $order->shipping_name }}</td>
                                <td>{{ $order->payment_method == 'cod' ? 'COD' : 'Momo' }}</td>
                                {{-- <td>{{ number_format($order->total_amount, 0, '.', '.') }}đ</td> --}}
                                <td><span
                                        class="badge bg-label-secondary me-1">{{ $order->status == 'pending' ? 'Chờ duyệt' : '' }}</span>
                                </td>
                                <td>
                                    <div>
                                        <a class="btn btn-sm btn-primary" href="javascript:void(0);">
                                            Chi tiết</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="mt-3">{{ $orders->links() }}</div> --}}
        </div>
    </div>
@endsection
