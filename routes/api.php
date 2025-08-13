<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:sanctum');
    });

    Route::prefix('tasks')->controller(TaskController::class)->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', 'index');
        Route::get('/{task}', 'show');
        Route::put('/{task}', 'update');
        Route::delete('/{task}', 'delete');
    });
});
