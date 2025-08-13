<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Enums\User\UserRole;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
        if (!Gate::allows(UserRole::ADMIN->value)) {
            abort(403);
        }
    }
    public function listAll()
    {

        $users =  $this->service->listAll();

        return view('admin.user.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $user = $this->service->show($user);

        return view('admin.user.show', ['user' => $user]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        try {
            $user = $this->service->create($data);
            flash()->success('User Create Successfully');
            Log::info(message: 'User Created Successfully', context: [
                'created_user_id' => $user->id,
                'creator_Id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            Log::error('failed to create user', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        try {
            $user = $this->service->update($data, $user);
            flash()->success('user Created Successfully');
            Log::info(message: "User Updated Successfully", context: [
                'admin_who_updated' => auth()->id(),
                'updated_user_id' => $user->id,
            ]);
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            Log::error('failed to update user', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.users.index');
        }
    }
    public function destroy(User $user)
    {
        try {
            $this->service->delete($user);
            flash()->success('User Deleted Successfully');
            Log::info(message: 'User Deleted Successfully', context: [
                'deleted_user_id' => $user->id,
                'admin_who_deleted' => auth()->id(),
            ]);
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            Log::error('Failed to delete user', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.users.index');
        }
    }
}
