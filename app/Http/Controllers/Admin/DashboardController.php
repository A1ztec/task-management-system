<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {


        $totalTasks = Task::count();
        $pendingTasks = Task::pending()->count();
        $completedTasks = Task::done()->count();
        $inProgressTasks = Task::inProgress()->count();
        $users = User::count();

        $data = [
            'total tasks' => $totalTasks,
            'pending tasks' => $pendingTasks,
            'completed tasks' => $completedTasks,
            'in progress tasks' => $inProgressTasks,
            'total Users' => $users
        ];
        return view('admin.dashboard', ['data' => $data]);
    }
}
