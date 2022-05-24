<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::put('tasks/{id}', [TaskController::class, 'doneUndo'])
    ->whereNumber('id');
Route::post('tasks/clear', [TaskController::class, 'clearCompleted']);
Route::apiResource('tasks', TaskController::class);
