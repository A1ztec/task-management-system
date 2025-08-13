<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
{
    public function listAll(): mixed
    {
        $users =  User::paginate();
        return $users;
    }

    public function show(User $user): User
    {
        return $user;
    }

    public function create($data): User
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'email_verified_at' => now(),
        ]);

        return $user;
    }

    public function update($data, User $user): User
    {
        $user->update($data);
        $user = $user->fresh();
        return $user;
    }

    public function delete(User $user): bool
    {
        $delete = $user->delete();
        return $delete;
    }
}
