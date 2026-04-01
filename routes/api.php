<?php

use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/department', [DepartmentController::class, 'store'])->name('api.department.store');

Route::get('/task', [TaskController::class, 'index'])->name('api.task.index');
Route::get('/tasks/report', [TaskController::class, 'report'])->name('api.tasks.report');
Route::post('/task', [TaskController::class, 'store'])->name('api.task.store');
Route::patch('/task/{task}/status', [TaskController::class, 'updateStatus'])->name('api.task.updateStatus');
Route::delete('/task/{task}', [TaskController::class, 'destroy'])->name('api.task.destroy');
