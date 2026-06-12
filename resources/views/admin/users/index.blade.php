@extends('admin.layout.master')

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">Danh sách người dùng</h5>
        <div class="card-header">
            <div class="mb-3">
                <form action="{{ route('admin.users') }}" method="get">
                    <div class="row">
                        <div class="col">
                            <label for="" class="form-label">Email</label>
                            <input value="{{ request('email') }}" type="text" class="form-control form-control-sm"
                                name="email" placeholder="Nhập email">
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" id="" class="form-select form-select-sm">
                                <option value="" selected>Tất cả</option>
                                <option {{ request('status') == 'active' ? 'selected' : '' }} value="active">Đang hoạt động
                                </option>
                                <option {{ request('status') == 'deactive' ? 'selected' : '' }} value="deactive">Chưa hoạt
                                    động</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary"><i class='bx bx-filter-alt'></i> Lọc</button>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary"><i class='bx bx-refresh'></i>
                            Reset</a>
                    </div>
                </form>
            </div>
            <div>
                <button type="button" id="btnActiveMulti" class="btn btn-sm btn-success">Kích hoạt</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td><input type="checkbox" class="form-check-input" id="checkAll"></td>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($users as $key => $user)
                            <tr>
                                <td><input type="checkbox" class="form-check-input checkItem" name="id-users[]"
                                        value="{{ $user->id }}"></td>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span
                                        class="badge bg-label-{{ $user->is_verify ? 'success' : 'secondary' }}">{{ $user->is_verify ? 'Hoạt động' : 'Chưa kích hoạt' }}</span>
                                </td>
                                <td>
                                    @if ($user->is_verify == false)
                                        <form action="{{ route('admin.users.active', $user->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button onclick="return confirm('Bạn có muốn kích hoạt tài khoản này.')"
                                                class="btn btn-sm btn-primary">Kích hoạt</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">Không có người dùng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>{{ $users->links() }}</div>
        </div>
    </div>
    <form action="{{ route('admin.users.activeAll') }}" method="post" id="bulkForm">
        @csrf
    </form>

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

        document.getElementById('btnActiveMulti').addEventListener('click', function() {
            const checked = document.querySelectorAll('.checkItem:checked');
            if (checked.length === 0) {
                alert('Vui lòng chọn ít nhất 1 người dùng');
                return;
            }
            if (!confirm('Kích hoạt các tài khoản đã chọn?')) return;

            const form = document.getElementById('bulkForm');
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id-users[]';
                input.value = cb.value;
                form.appendChild(input);
            });
            form.submit();
        });
    </script>
@endsection
