<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request) {
        $users = $this->userService->getAll($request);

        return view('admin.users.index', compact('users'));
    }

    public function active($id) {
        $result = $this->userService->active($id);
        if(!$result) {
            alert('Lỗi.', 'Kích hoạt không thành công.', 'error');
            return redirect()->back();
        }

        alert('Thành công.', 'Kích hoạt tài khoản thành công.', 'success');
        return redirect()->back();
    }

    public function activeAll(Request $request) {
        $this->userService->activeAll($request);

        alert('Thành công.', 'Kích hoạt tài khoản thành công.', 'success');
        return redirect()->back();
    }
}
