@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">Danh sách đơn hàng</h5>
        <div class="card-header">
            <form action="{{ route('admin.orders') }}" method="get">
                <div class="row">
                    <div class="col">
                        <label for="" class="form-label">Mã đơn</label>
                        <input type="text" name="id" value="{{ request('id') }}"
                            class="form-control form-control-sm">
                    </div>
                    <div class="col">
                        <label for="status-order" class="form-label">Trạng thái</label>
                        <select id="status-order" class="form-select form-select-sm" name="status"
                            aria-placeholder="Trạng thái">
                            <option selected disabled>Chọn trạng thái</option>
                            @foreach ($statuses as $key => $status)
                                <option {{ request('status') == $key ? 'selected' : '' }} value="{{ $key }}">
                                    {{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="status-order" class="form-label">Phương thức thanh toán</label>
                        <select id="status-order" name="payment-method" class="form-select form-select-sm"
                            aria-placeholder="Trạng thái">
                            <option selected disabled>Chọn phương thức</option>
                            <option {{ request('payment-method') == 'cod' ? 'selected' : '' }} value="cod">Thanh toán khi
                                nhận hàng</option>
                            <option {{ request('payment-method') == 'momo' ? 'selected' : '' }} value="momo">Ví điện tử
                                Momo</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="bx bx-filter-alt"></i> Lọc</button>
                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-refresh"></i> Reset
                    </a>
                </div>
            </form>
            <div>
                <button type="button" name="action" onclick="submitAction('processing')" class="btn btn-sm btn-info"><i
                        class="bx bx-x"></i> Duyệt đơn</button>
                <button type="button" name="action" onclick="submitAction('cancelled')" class="btn btn-sm btn-warning"><i
                        class="bx bx-x"></i> Hủy đơn</button>
                <button type="button" name="action" onclick="submitAction('remove')" class="btn btn-sm btn-danger"><i
                        class="bx bx-trash"></i> Xóa</button>
            </div>
        </div>
        <div class="card-body">
            <form id="formAction" action="{{ route('admin.order.all') }}" method="post">
                @csrf
                <input type="hidden" name="action" id="actionInput">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <td><input type="checkbox" class="form-check-input" id="checkAll"></td>
                                <th>STT</th>
                                <th>Mã đơn</th>
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
                                    <td><input type="checkbox" name="id[]" value="{{ $order->id }}"
                                            class="form-check-input checkItem"></td>
                                    <td>{{ $orders->firstItem() + $key }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->shipping_name }}</td>
                                    <td>{{ $order->payment_method == 'cod' ? 'Thanh toán COD' : 'Ví Momo' }}</td>
                                    <td><span
                                            class="text-danger fw-bold">{{ number_format($order->total_amount, 0, '.', '.') }}đ</span>
                                    </td>
                                    <td><span
                                            class="badge bg-label-{{ $statuses[$order->status]['color'] }} me-1">{{ $statuses[$order->status]['label'] }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.orders.detail', $order->id) }}">
                                                Chi tiết</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $orders->links() }}</div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
        });

        document.querySelectorAll('.checkItem').forEach(cb => {
            cb.addEventListener('change', function() {
                const all = document.querySelectorAll('.checkItem').length;
                const checked = document.querySelectorAll('.checkItem:checked').length;
                document.getElementById('checkAll').checked = all === checked;
            });
        });

        function submitAction(action) {
            const checked = document.querySelectorAll('.checkItem:checked').length;
            if (checked === 0) {
                return;
            }

            if (confirm('Bạn có muốn thực hiện hành động này?')) {
                document.getElementById('actionInput').value = action;
                document.getElementById('formAction').submit();
            }
        }
    </script>
@endsection
