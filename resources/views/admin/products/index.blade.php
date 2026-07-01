@extends('admin.layout.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">Danh sách sản phẩm</h5>
        <div class="card-header">
            <div class="mb-5">
                <form action="{{ route('admin.products') }}" method="get">
                    <div class="row">
                        <div class="col">
                            <label for="" class="form-label">Tên sản phẩm</label>
                            <input value="{{ request('name') }}" type="text" class="form-control form-control-sm" name="name" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" id="" class="form-select form-select-sm">
                                <option value="" selected>Tất cả</option>
                                <option {{ request('status') == 'active' ? 'selected' : '' }} value="active">Đang hoạt động</option>
                                <option {{ request('status') == 'deactive' ? 'selected' : '' }} value="deactive">Chưa hoạt động</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Số lượng</label>
                            <select name="quantity" id="" class="form-select form-select-sm">
                                <option value="" selected>Tất cả</option>
                                <option {{ request('quantity') == 'low-stock' ? 'selected' : '' }} value="low-stock">Gần hết hàng</option>
                                <option {{ request('quantity') == 'almost-stock' ? 'selected' : '' }} value="almost-stock">Sắp hết hàng</option>
                                <option {{ request('quantity') == 'out-of-stock' ? 'selected' : '' }} value="out-of-stock">Hết hàng</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary"><i class='bx bx-filter-alt' ></i> Lọc</button>
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-secondary"><i class='bx bx-refresh' ></i> Reset</a>
                    </div>
                </form>
            </div>
            <div class="d-flex">
                <div class="me-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class='bx bxs-file-import'></i> Import file
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Tải file excel lên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.prouducts.import') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">File</label>
                                                <input type="file" id="nameBasic" required name="file-import"
                                                    class="form-control" />
                                                @error('file-import')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Đóng
                                        </button>
                                        <button type="submit" class="btn btn-primary">Gửi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.products.export') }}" class="btn btn-sm btn-info"><i class='bx bxs-file-export'></i> Tải file
                    mẫu</a>
                <div class="ms-3">
                    <button type="button" onclick="submitAction('active')" class="btn btn-sm btn-success"><i class='bx bx-show' ></i> Hiển thị</button>
                    <button type="button" onclick="submitAction('deactive')" class="ms-2 btn btn-sm btn-secondary"><i class='bx bx-hide' ></i> Vô
                        hiệu</button>
                    <button type="button" onclick="submitAction('delete')" class="ms-2 btn btn-sm btn-danger"><i class='bx bxs-trash-alt'></i> Xóa</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </td>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($products as $key => $product)
                            <tr>
                                <td><input type="checkbox" class="form-check-input checkItem" name="id-product[]"
                                        value="{{ $product->id }}"></td>
                                <td>{{ $products->firstItem() + $key }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @if ($product->thumbnail)
                                        <img src="{{ Storage::url($product->thumbnail->path) }}" alt=""
                                            width="100" />
                                    @else
                                        <span>Chưa có ảnh</span>
                                        <a href="{{ route('product-images.create', $product->slug) }}"
                                            class="btn btn-sm btn-primary">Tải ảnh lên</a>
                                    @endif
                                </td>
                                <td>{{ number_format($product->price, '0', '.', '.') }}đ</td>
                                <td>
                                    <div class="mb-2">{{ $product->stock }}</div>
                                    @if ($product->stock == 0)
                                        <span class="badge bg-label-danger">Hết hàng</span>
                                    @elseif ($product->stock <= 5)
                                        <span class="badge bg-label-danger">Sắp hết hàng</span>
                                    @elseif ($product->stock <= 10)
                                        <span class="badge bg-label-warning">Gần hết hàng</span>
                                    @endif
                                </td>
                                <td><span
                                        class="badge bg-label-{{ $product->is_active === 1 ? 'success' : 'secondary' }} me-1">{{ $product->is_active === 1 ? 'Hoạt động' : 'Chưa hoạt động' }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.detail', $product->slug) }}"><i
                                                    class="bx bx-info-circle me-1"></i>
                                                Chi tiết</a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.products.edit', $product->slug) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Sửa</a>
                                            <form action="{{ route('admin.products.delete', $product->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này.')"><i
                                                        class="bx bx-trash me-1"></i>
                                                    Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="mt-3">{{ $products->links() }}</div>
        </div>
    </div>
    <form action="{{ route('admin.products.all') }}" method="post" id="formAction">
        @csrf
        <input type="hidden" name="action" id="actionInput">
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

        function submitAction(action) {
            const checked = Array.from(document.querySelectorAll('.checkItem:checked'));
            if (checked.length === 0) {
                return;
            }

            if (confirm('Bạn có muốn thực hiện hành động này?')) {
                document.querySelectorAll('.dynamicId').forEach(el => el.remove());

                checked.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id-product[]';
                    input.value = cb.value;
                    input.classList.add('dynamicId');
                    document.getElementById('formAction').appendChild(input);
                });
                document.getElementById('actionInput').value = action;
                document.getElementById('formAction').submit();
            }
        }
    </script>
@endsection
