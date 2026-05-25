@extends('admin.layout.master')

@section('title')
    Cập nhật - {{ $category->name }}
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cập nhật danh mục</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('categories.update', $category->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên danh mục</label>
                    <input type="text" class="form-control" id="basic-default-fullname" name="name" value="{{ $category->name }}" placeholder="Nhập tên danh mục" />
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection