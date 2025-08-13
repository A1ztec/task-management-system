<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Enums\User\UserRole;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\user\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
        if (!Gate::allows('admin')) {
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

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        try {
            $user = $this->service->create($data);
            flash()->success('User Created Successfully');
            Log::info(message: 'User Created Successfully', context: [
                'created_user_id' => $user->id,
                'creator_Id' => auth()->id(),
            ]);
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            Log::error('failed to create user', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.users.create')->withInput([
                'email' => old('email'),
                'name' => old('name'),
                'role' => old('role'),
            ]);
        }
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        try {
            $user = $this->service->update($data, $user);
            flash()->success('User Updated Successfully');
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
            return redirect()->route('admin.users.edit', $user);
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
