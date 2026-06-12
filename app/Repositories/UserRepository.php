<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll($data) {
        return User::where('role', 'customer')->when($data['email'] ?? null, function ($query, $email) {
            $query->where('email', 'like', '%' . $email . '%');
        })
        ->when(isset($data['status']) && $data['status'] !== '', function ($query) use ($data) {
            if($data['status'] === 'active') {
                $query->where('is_verify', true);
            } elseif ($data['status'] === 'deactive') {
                $query->where('is_verify', false);
            }
        })
        ->latest()->paginate(10)->withQueryString();
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

    public function active($id) {
        return User::findOrFail($id)->update([
            'is_verify' => true,
            'verify_token' => null
        ]);
    }
}