<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Enums\User\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function Showlogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {
            if (!Auth::attempt($data)) {
                flash()->error(__('Wrong Credentials'));
                return redirect()->back()->withInput(request()->only('email'));
            }

            if (!Auth::user()->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                flash()->error(__('you are not authorized to access this panel'));
                return redirect()->back()->withInput(request()->only('email'));
            }

            $request->session()->regenerate();

            flash()->success(__('Welcome, :name', ['name' => auth()->user()->name]));
            return redirect()->route('admin.dashboard');
        } catch (Exception $e) {
            Log::error(message: $e->getMessage());
            flash()->error($e->getMessage());
            return redirect()->back()->withInput(request()->only('email'));
        }
    }


    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        flash()->success(__('user Logged Out Successfully'));
        return redirect()->route('admin.auth.login');
    }
}
