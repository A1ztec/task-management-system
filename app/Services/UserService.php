<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserService
{

    public function __construct(private UserRepositoryInterface $repository) {}
    public function listAll(): mixed
    {
        $users = $this->repository->listAll();
        return $users;
    }

    public function create($data): User
    {
        $user = $this->repository->create($data);
        return $user;
    }

    public function show(User $user): User
    {
        $user = $this->repository->show($user);
        return $user;
    }

    public function update($data, User $user): User
    {
        $user =  $this->repository->update($data, $user);
        return $user;
    }

    public function delete(User $user)
    {
        return  $this->repository->delete($user);
    }
}
