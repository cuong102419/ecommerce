<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\VerifyAccountMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function updateProfile($request)
    {
        return $this->userRepository->update(Auth::id(), $request);
    }

    public function create(array $request)
    {
        $request['verify_token'] = str()->random(40);
        $user = $this->userRepository->create($request);
        $verifyUrl = route('verifyAccount', $user->verify_token);
        SendMailJob::dispatch($user->email, new VerifyAccountMail($user, $verifyUrl));

        return true;
    }

    public function verifyAccount($token) {
        return $this->userRepository->verify($token);
    }
}
