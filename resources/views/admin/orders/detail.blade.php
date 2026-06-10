@extends('admin.layout.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Chi tiết đơn hàng</h5>
            <form class="me-3" action="{{ route('admin.orders.status', $order->id) }}" method="post">
                @csrf
                @method('PUT')
                @if ($order->status == 'pending')
                    <button type="submit" name="action" value="processing"
                        onclick="return confirm('Bạn có muốn duyệt đơn này.')" class="btn btn-sm btn-primary"><i
                            class="bx bx-check"></i> Xác nhận</button>
                    <button type="submit" name="action" value="cancelled"
                        onclick="return confirm('Bạn có muốn hủy đơn này.')" class="btn btn-sm btn-danger"><i
                            class="bx bx-x"></i> Hủy</button>
                @elseif ($order->status == 'processing' || $order->status == 'paid')
                    <button type="submit" name="action" value="shipped"
                        onclick="return confirm('Bạn có muốn đổi trạng thái đơn này.')" class="btn btn-sm btn-info"><i
                            class="bx bxs-truck"></i> Vận chuyển</button>
                @elseif ($order->status == 'shipped')
                    <button type="submit" name="action" onclick="return confirm('Bạn có muốn đổi trạng thái đơn này.')"
                        value="delivered" class="btn btn-sm btn-success"><i class="bx bx-package"></i> Đã giao</button>
                @endif
                @if ($order->payment_method == 'momo' && $order->status == 'paid')
                    <button type="submit" name="action" onclick="return confirm('Bạn có muốn hoàn tiền đơn này.')"
                        value="refunded" class="btn btn-sm btn-warning"><i class="bx bx-transfer"></i> Hoàn tiền & hủy
                        đơn</button>
                @endif
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <tr>
                        <th>Trạng thái đơn hàng</th>
                        <td colspan="2"><strong
                                class="text-{{ $statuses[$order->status]['color'] }}">{{ $statuses[$order->status]['label'] }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Phương thức thanh toán</th>
                        <td colspan="2">{{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Ví điện tử Momo' }}</td>
                    </tr>
                    <tr>
                        <th>Sản phẩm</th>
                        <td></td>
                        <th>Giá</th>
                    </tr>
                    @foreach ($orderItem as $item)
                        <tr>
                            <td>
                                <div class="">
                                    <strong class="d-block">{{ $item->product_name }}</strong>
                                    <span class="d-block"><strong>Số lượng:</strong> {{ $item->quantity }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="ms-3">
                                    <img src="{{ Storage::url($item->product_image) }}" width="130" alt="">
                                </div>
                            </td>
                            <td>{{ number_format($item->unit_price, 0, '.', '.') }}đ</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Vận chuyển</th>
                        <td colspan="2"> 50.000 đ</td>
                    </tr>
                    <tr>
                        <th>Thành tiền</th>
                        <td colspan="2"><strong class="text-danger">{{ number_format($order->total_amount) }}đ</strong></td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td colspan="2">{{ $order->created_at->format('d-m-Y') }}</td>
                    </tr>
                </table>
                <div class="mt-5">
                    <h5>Thông tin khách hàng</h5>
                    <form class="mt-3" action="" method="post">
                        @csrf
                        <div>
                            <label for="">Họ tên</label>
                            <input type="text" class="form-control"
                                {{ !in_array($order->status, ['pending', 'paid']) ? 'disabled' : '' }}
                                value="{{ $order->shipping_name }}" placeholder="Họ tên">
                        </div>
                        <div class="mt-3">
                            <label for="">Số điện thoại</label>
                            <input type="tel" class="form-control"
                                {{ !in_array($order->status, ['pending', 'paid']) ? 'disabled' : '' }}
                                value="{{ $order->shipping_phone }}" placeholder="Số điện thoại">
                        </div>
                        <div class="mt-3">
                            <label for="">Địa chỉ</label>
                            <input type="tel" class="form-control"
                                {{ !in_array($order->status, ['pending', 'paid']) ? 'disabled' : '' }}
                                value="{{ $order->shipping_address }}" placeholder="Địa chỉ">
                        </div>
                        <div class="mt-3">
                            <label for="">Ghi chú</label>
                            <textarea class="form-control" name="" {{ !in_array($order->status, ['pending', 'paid']) ? 'disabled' : '' }}
                                id="" placeholder="Ghi chú đơn hàng">{{ $order->note }}</textarea>
                        </div>
                        @if (in_array($order->status, ['pending', 'paid']))
                            <div class="mt-3">
                                <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
