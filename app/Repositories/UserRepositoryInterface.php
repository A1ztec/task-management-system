<?php

namespace App\Repositories;

use App\Http\Resources\User\UserResource;
use App\Models\User;


interface UserRepositoryInterface
{
    public function listAll(): mixed;


    public function show(User $user): User;

    public function create($data): User;

    public function update($data, User $user): User;

    public function delete(User $user): bool;
}
