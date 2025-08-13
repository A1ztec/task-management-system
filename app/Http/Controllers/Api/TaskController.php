<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Task\TaskResource;
use App\Http\Requests\Task\TaskRequest;

class TaskController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks =  Task::with('user')->filter()->paginate(15);

        $tasks = TaskResource::collection($tasks);

        return $this->successResponse(code: 200, message: _('Tasks Retrived Successfuly'), data: $tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {

        $data = $request->validated();

        $user = Auth::user();
        try {
            $task =  Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'status' => $data['status'],
                'due_date' => $data['due_date'],
                'user_id' => $data['user_id'],
            ]);
            Log::info(message: 'task created successfuly');

            $task = TaskResource::make($task);

            return $this->successResponse(message: __('Task Created Successfuly'), data: $task);
        } catch (Throwable $e) {
            Log::error(message: $e->getMessage());
            return $this->errorResponse(message: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $task->load('user');
            $task = TaskResource::make($task);

            return $this->successResponse(code: 200, message: __('Task Retrived Successfuly'));
        } catch (Throwable $e) {
            Log::error(message: $e->getMessage());
            return $this->errorResponse(message: $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        try {
             $task->update([$data]);
             $task = TaskResource::make($task->load('user'));
            Log::info(message: 'Task Updated Successfuly');
            return $this->successResponse(message: __('Task Updated Successfuly'), data: $task);
        } catch (Throwable $e) {
            Log::error(message: $e->getMessage());
            return $this->errorResponse(message : $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->successResponse(message : __('Task Deleted Successfuly'))
    }
}
