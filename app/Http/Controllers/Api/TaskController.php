<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests;


    public function __construct(public TaskService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Task::class);

            $tasks =  $this->service->listAll();

            //dd($tasks);
            $tasks = TaskResource::collection($tasks);

            return $this->successResponse(code: 200, message: __('Tasks Retrieved Successfully'), data: $tasks);
        } catch (Exception $e) {
            return $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {

        $data = $request->validated();

        try {
            $this->authorize('create', Task::class);

            $task =  $this->service->create($data);

            Log::info(message: 'task created successfuly');

            $task = TaskResource::make($task);

            return $this->successResponse(message: __('Task Created Successfully'), data: $task);
        } catch (Exception $e) {
            return $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $this->authorize('view', $task);
            $task = $this->service->show($task);
            $task->load('user');
            $task = TaskResource::make($task);

            return $this->successResponse(code: 200, message: __('Task Retrieved Successfully'), data: $task);
        } catch (Exception $e) {
            return $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $user = Auth::user();
        if (!$user->isAdmin()) {
            $data = [
                'status' => $data['status'] ?? $task->status
            ];
        }
        try {
            $this->authorize('update', $task);
            $task = $this->service->update($data, $task);
            $task = $task->load('user');
            $task = TaskResource::make($task);
            Log::info(message: 'Task Updated Successfuly');
            return $this->successResponse(message: __('Task Updated Successfully'), data: $task);
        } catch (Exception $e) {
            return $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $this->authorize('delete', $task);
            $this->service->delete($task);
            return $this->successResponse(message: __('Task Deleted Successfully'));
        } catch (Exception $e) {
            return  $this->logAndReturnErrorResponse($e->getMessage());
        }
    }
}
