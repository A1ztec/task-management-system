<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Task\TaskRequest;

class TaskController extends Controller
{


    public function __construct(public TaskService $service)
    {
        if (!Gate::allows('admin')) {
            abort(403);
        }
    }

    public function listAll()
    {
        $tasks = $this->service->listAll();
        return view('admin.task.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task = $this->service->show($task);

        return view('admin.task.show', ['task' => $task]);
    }

    public function create()
    {
        $users = User::all();
        return view('admin.task.create', ['users' => $users]);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        try {
            $task = $this->service->create($data);
            flash()->success('Task Created Successfully');
            return redirect()->route('admin.tasks.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->route('admin.tasks.create')->withInput();
        }
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('admin.task.edit', ['task' => $task, 'users' => $users]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        try {
            $this->service->update(data: $data, task: $task);
            flash()->success('Task Updated Successfully');
            return redirect()->route('admin.tasks.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->route('admin.tasks.edit', ['task' => $task])->withInput();
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->service->delete($task);
            flash()->success('Task Deleted Successfully');
            return redirect()->route('admin.tasks.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->route('admin.tasks.index');
        }
    }
}
