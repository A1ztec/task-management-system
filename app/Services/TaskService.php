<?php


namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;

class TaskService
{

    public function __construct(public TaskRepositoryInterface $repository) {}


    public function listAll()
    {

        return $this->repository->listAll();
    }


    public function create($data)
    {
        return $this->repository->create($data);
    }


    public function update($data, Task $task): Task
    {
        return $this->repository->update($data, $task);
    }

    public function delete(Task $task)
    {
        return $this->repository->delete($task);
    }
}
