<?php

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TaskRepositoryInterface;


class TaskRepository implements TaskRepositoryInterface

{
    public function listAll(): mixed
    {

        $query = Task::with('user')->filter()->paginate(15);

        $user = Auth::user();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function create($data): Task
    {

        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'status' => $data['status'],
            'due_date' => $data['due_date'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function update($data, Task $task): mixed
    {

        $task =  $task->update($data);

        return $task ; 
    }

    public function delete(Task $task): bool
    {

        return $task->detete();
    }
}
