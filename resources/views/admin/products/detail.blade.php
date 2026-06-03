@extends('admin.layout.master')

@section('content')
    <div class="card">
        <h4 class="card-header">Chi tiết sản phẩm</h4>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Danh mục</strong></td>
                        <td>{{ $product->category->name }}</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Trạng thái</strong></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span
                                    class="badge bg-label-{{ $product->is_active === 1 ? 'success' : 'secondary' }} me-1">{{ $product->is_active === 1 ? 'Hoạt động' : 'Chưa hoạt động' }}</span>
                                <form action="{{ route('admin.products.updateStatus', $product->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-primary">Đổi trạng thái</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Tên sản phẩm</strong></td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Giá</strong></td>
                        <td>{{ number_format($product->price, 0, '.', '.') }}đ</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Tồn kho</strong></td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Hình ảnh</strong></td>
                        <td class="d-flex justify-content-between">
                            <img src="{{ Storage::url($product->thumbnail->path) }}" width="120" alt="">
                            <div><button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#basicModal">Tải ảnh mới</button></div>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Mô tả</strong></td>
                        <td>{!! $product->description !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Tải ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('product-images.update', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">File</label>
                                    <input type="file" id="nameBasic" required name="path" class="form-control" />
                                    @error('path')
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
@endsection
