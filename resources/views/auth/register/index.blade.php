@extends('auth.layout.master')

@section('content')
    <form id="formAuthentication" class="mb-3" action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="username" name="name" placeholder="Nhập họ tên của bạn"
                autofocus />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                placeholder="Nhập địa chỉ email của bạn" />
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Mật khẩu</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="confirm-password">Xác nhận mật khẩu</label>
            <div class="input-group input-group-merge">
                <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="confirm-password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                <label class="form-check-label" for="terms-conditions">
                    Tôi đồng ý với
                    <a href="javascript:void(0);">chính sách bảo mật và điều khoản</a>
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100">Đăng ký</button>
    </form>

    <p class="text-center">
        <span>Đã có tài khoản?</span>
        <a href="{{ route('login') }}">
            <span>Đăng nhập</span>
        </a>
    </p>
@endsection
