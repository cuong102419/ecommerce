<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartItemService;

class LoginController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository,
        protected CartItemService $cartItemService
    ) {}
    public function index()
    {
        return view('auth.login.index');
    }

    public function login(LoginRequest $request)
    {
        $oldSessionId = session()->getId();
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        
        $this->cartItemService->mergeCart($oldSessionId);

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }


        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
