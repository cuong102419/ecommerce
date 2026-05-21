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
        $user->update($data);
        return $user;
    }

    public function delete($id) {
        return User::destroy($id);
    }
}