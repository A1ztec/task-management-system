<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function listAll(): mixed;

    public function create($data): Task;

    public function update($data, Task $task): Task;

    public function delete(Task $task): bool;
}
