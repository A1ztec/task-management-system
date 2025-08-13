<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TaskRepositoryInterface;


class TaskRepository implements TaskRepositoryInterface

{
    public function listAll(): mixed
    {

        $query = Task::with('user');

        $user = Auth::user();

        if (!$user->isAdmin()) {

            $query->where('user_id', $user->id);
        }

        $query =  $query->filter()->paginate(15);

        //dd($query->tosql());

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

    public function update($data, Task $task): Task
    {

        $task->update($data);

        return $task;
    }

    public function delete(Task $task): bool
    {

        return $task->delete();
    }
}
