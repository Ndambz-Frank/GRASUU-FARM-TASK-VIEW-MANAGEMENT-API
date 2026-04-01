<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(Department $department): View
    {
        return view('tasks.create', compact('department'));
    }

    public function show(Department $department, Task $task): View
    {
        return view('tasks.show', compact('department', 'task'));
    }

    public function edit(Department $department, Task $task): View
    {
        return view('tasks.edit', compact('department', 'task'));
    }

    public function update(Request $request, Department $department, Task $task): RedirectResponse
    {
        $validated = $this->validateTask($request, $department, $task);

        $task->update($validated);

        return redirect()
            ->route('departments.show', $department)
            ->with('flash_message', 'Task updated successfully.');
    }

    private function validateTask(Request $request, Department $department, ?Task $task = null): array
    {
        $uniqueTitle = Rule::unique('tasks')->where(function ($query) use ($request, $department) {
            return $query
                ->where('department_id', $department->id)
                ->where('due_date', $request->input('due_date'));
        });

        if ($task) {
            $uniqueTitle = $uniqueTitle->ignore($task->id);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255', $uniqueTitle],
            'due_date' => ['required', 'date'],
            'due_time' => ['required', 'date_format:H:i'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Pending,In-Progress,Done'],
        ]);
    }
}
