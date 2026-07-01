<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;

class RegisterController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        return view('auth.register.index');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $this->userService->create($data);

        alert('Thành công.', 'Đăng ký thành công, vui lòng kiểm tra email để xác thực tài khoản.', 'success');
        return redirect()->route('login');
    }

    public function verifyAccount($token)
    {
        $result = $this->userService->verifyAccount($token);
        if (!$result) {
            alert('Lỗi', 'Không tìm thấy tài khoản.', 'error');
            return redirect()->route('login');
        }

        alert('Thành công', 'Tài khoản đã được xác thực. Vui lòng đăng nhập lại', 'success');
        return redirect()->route('login');
    }
}
