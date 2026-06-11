<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll() {
        return User::all();
    }

    public function findById($id) {
        return User::findOrFail($id);
    }

    public function findByEmail($email) {
        return User::where("email", $email)->first();
    }

    public function create($data = []) {
        return User::create($data);
    }

    public function update($id, $data = []) {
        $user = User::findOrFail($id);
        return $user->update($data);
    }

    public function delete($id) {
        return User::destroy($id);
    }

    public function verify($token) {
        $user = User::where('verify_token' , $token)->firstOrFail();

        return $user->update([
            'is_verify' => true,
            'verify_token' => null
        ]);
    }
}