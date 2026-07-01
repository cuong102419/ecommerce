<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index() {
        return view('client.profile.index');
    }

    public function update(UpdateProfileRequest $request) {
        $data = $request->validated();
        $this->userService->updateProfile($data);

        alert("Thành công", 'Cập nhật thông tin thành công.', 'success');
        return redirect()->back();
    }
}
