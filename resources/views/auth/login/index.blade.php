@extends('auth.layout.master')

@section('content')
    <form id="formAuthentication" class="mb-3" action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập địa chỉ email của bạn"
                autofocus />
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Mật khẩu</label>
            </div>
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
        <div class="mb-3">
            <a href="auth-forgot-password-basic.html">
                <small>Quên mật khẩu?</small>
            </a>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Đăng nhập</button>
        </div>
    </form>

    <span>Chưa có tài khoản?</span>
    <a href="{{ route('register') }}">
        <span>Đăng ký</span>
    </a>
@endsection
