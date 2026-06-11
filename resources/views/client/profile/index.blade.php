@extends('client.layout.master')

@section('title')
    Thông tin tài khoản
@endsection

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Thông tin tài khoản</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <div class="detail-order-section mt-80 mb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <h4>Thông tin tài khoản</h4>
                    <form action="{{ route('user.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="" class="form-label">Email</label>
                            <input type="email" disabled value="{{ Auth::user()->email }}" class ="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="">Họ tên</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="">Mật khẩu cũ</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="">Xác nhận mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Nhập lại mật khẩu mới">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <button class="cart-btn" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
