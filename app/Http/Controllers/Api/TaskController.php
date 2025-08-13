<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Task\TaskResource;
use App\Http\Requests\Task\TaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny');

            $query = Task::with('user');
            $user = Auth::user();

            if (!$user->isAmin) {
                $query->where('user_id', $user->id);
            }
            $tasks = $query->filter()->paginate(15);

            $tasks = TaskResource::collection($tasks);

            return $this->successResponse(code: 200, message: __('Tasks Retrieved Successfully'), data: $tasks);
        } catch (Exception $e) {
            $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {


        $data = $request->validated();


        try {
            $this->authorize('create');
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

            return $this->successResponse(message: __('Task Created Successfully'), data: $task);
        } catch (Exception $e) {
            $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $this->authorize('view', $task);
            $task->load('user');
            $task = TaskResource::make($task);

            return $this->successResponse(code: 200, message: __('Task Retrieved Successfully'), data: $task);
        } catch (Exception $e) {
            $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        try {
            $this->authorize('update', $task);
            $task->update($data);
            $task = TaskResource::make($task->load('user'));
            Log::info(message: 'Task Updated Successfuly');
            return $this->successResponse(message: __('Task Updated Successfully'), data: $task);
        } catch (Exception $e) {
            $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $this->authorize('delete', $task);
            $task->delete();
            return $this->successResponse(message: __('Task Deleted Successfully'));
        } catch (Exception $e) {
            return  $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    private function logAndReturnErrorResponse(string $message)
    {
        Log::error(message: $message);
        return $this->errorResponse(message: $message);
    }
}
