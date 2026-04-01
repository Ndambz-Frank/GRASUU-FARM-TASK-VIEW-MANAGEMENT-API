<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->with('department')
            ->orderByRaw("CASE priority WHEN 'High' THEN 1 WHEN 'Medium' THEN 2 WHEN 'Low' THEN 3 ELSE 4 END")
            ->orderBy('due_date')
            ->orderBy('due_time')
            ->get();

        return view('home', compact('tasks'));
    }
}
