@extends('admin.layout.master')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cập nhật sản phẩm</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.products.update', $product->id) }}">  
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="exampleFormControlSelect1" class="form-label">Danh mục sản phẩm</label>
                        <select class="form-select" name="category_id" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option selected disabled>Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="basic-default-company">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" id="basic-default-company"
                            placeholder="Nhập tên sản phẩm" value="{{ $product->name }}" />
                        @error('name')
                            <span class="text-danger mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label" for="basic-default-email">Giá</label>
                        <div class="input-group input-group-merge">
                            <input type="number" name="price" min="0" step="0.1" id="basic-default-email"
                                class="form-control" placeholder="Nhập giá sản phẩm" aria-label="john.doe"
                                aria-describedby="basic-default-email2" value="{{ $product->price }}"/>
                        </div>
                        @error('price')
                            <span class="text-danger mt-3">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="basic-default-phone">Số lượng</label>
                        <input type="number" name="stock" min="1" id="basic-default-phone"
                            class="form-control phone-mask" placeholder="Nhập số lượng" value="{{ $product->stock }}" />
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-message">Mô tả</label>
                    @error('description')
                        <div>
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                    @enderror
                    <textarea id="basic-default-message" name="description" class="form-control" rows="10"
                        placeholder="Nhập mô tả sản phẩm.">{{ $product->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
