<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('doLogin');
        Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    });

    Route::middleware(['admin', 'auth'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
            Route::get('/', 'listAll')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}', 'show')->name('show');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

        Route::prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::get('/', 'listAll')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{task}', 'show')->name('show');
            Route::get('/{task}/edit', 'edit')->name('edit');
            Route::put('/{task}', 'update')->name('update');
            Route::delete('/{task}', 'destroy')->name('destroy');
        });
    });
});
