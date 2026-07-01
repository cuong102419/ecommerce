@extends('admin.layout.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('product-images.store', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ảnh sản phẩm</label>
                    <input class="form-control" type="file" name="path" id="formFile" />
                    @error('path')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <input type="hidden" name="sort_order" value="1">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
@endsection
