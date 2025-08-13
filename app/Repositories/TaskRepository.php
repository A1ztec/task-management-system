<?php

namespace App\Repositories;

use App\Http\Resources\Task\TaskResource;
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

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'status' => $data['status'],
            'due_date' => $data['due_date'],
            'user_id' => $data['user_id'],
        ]);
        return $task;
    }


    public function show($task): task
    {
        return $task;
    }

    public function update($data, Task $task): Task
    {

        $updateData = [];

        if (isset($data['title']) && !empty($data['title'])) {
            $updateData['title'] = $data['title'];
        }

        if (isset($data['description']) && !empty($data['description'])) {
            $updateData['description'] = $data['description'];
        }

        if (isset($data['priority']) && !empty($data['priority'])) {
            $updateData['priority'] = $data['priority'];
        }

        if (isset($data['status']) && !empty($data['status'])) {
            $updateData['status'] = $data['status'];
        }

        if (isset($data['due_date']) && !empty($data['due_date'])) {
            $updateData['due_date'] = $data['due_date'];
        }

        if (!empty($updateData)) {
            $task->update($updateData);
            $task = $task->fresh();
        }

        return $task;
    }

    public function delete(Task $task): bool
    {

        return $task->delete();
    }
}
