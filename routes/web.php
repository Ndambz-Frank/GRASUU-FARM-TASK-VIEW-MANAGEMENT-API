<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::resource('departments', DepartmentController::class)->only(['index', 'create', 'show']);

Route::resource('departments.tasks', TaskController::class)
    ->scoped()
    ->except(['index', 'store', 'destroy']);
