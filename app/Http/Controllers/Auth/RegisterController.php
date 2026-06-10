<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index() {
        return view('auth.register.index');
    }

    public function register(RegisterRequest $request) {
        $this->userRepository->create($request->validated());

        alert('Thành công.', 'Đăng ký thành công, hãy đăng nhập lại.', 'success');
        return redirect()->route('login');
    }
}
