@extends('admin.layout.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">Danh sách sản phẩm</h5>
        <div class="card-header d-flex">
            <div class="me-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal">
                    Import file
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
                            <form action="{{ route('admin.prouducts.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameBasic" class="form-label">File</label>
                                            <input type="file" id="nameBasic" required name="file-import" class="form-control" />
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
            <a href="{{ route('admin.products.export') }}" class="btn btn-sm btn-info">Tải file mẫu</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $key => $product)
                        <tr>
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
                            <td>{{ $product->stock }}</td>
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
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            Xóa</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body">
            {{ $products->links() }}
        </div>
    </div>
@endsection
