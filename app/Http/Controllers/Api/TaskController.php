<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::query()
            ->with('department')
            ->orderByRaw("CASE priority WHEN 'High' THEN 1 WHEN 'Medium' THEN 2 WHEN 'Low' THEN 3 ELSE 4 END")
            ->orderBy('due_date')
            ->orderBy('due_time')
            ->get();

        return response()->json([
            'message' => $tasks->isEmpty()
                ? 'No tasks found.'
                : 'Tasks retrieved successfully.',
            'data' => $tasks,
        ]);
    }

    public function report(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        $date = $validated['date'];

        $tasks = Task::query()
            ->whereDate('due_date', $date)
            ->get();

        $byPriority = collect(['High' => 0, 'Medium' => 0, 'Low' => 0])
            ->merge(
                $tasks->groupBy('priority')->map->count()
            );

        $byStatus = collect(['Pending' => 0, 'In-Progress' => 0, 'Done' => 0])
            ->merge(
                $tasks->groupBy('status')->map->count()
            );

        return response()->json([
            'message' => $tasks->isEmpty()
                ? 'No tasks are due on this date.'
                : 'Counts of tasks due on the requested date, grouped by priority and status.',
            'date' => $date,
            'by_priority' => $byPriority->all(),
            'by_status' => $byStatus->all(),
            'total_tasks' => $tasks->count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks')->where(function ($query) use ($request) {
                    return $query
                        ->where('department_id', $request->input('department_id'))
                        ->where('due_date', $request->input('due_date'));
                }),
            ],
            'due_date' => ['required', 'date'],
            'due_time' => ['required', 'date_format:H:i'],
            'priority' => ['required', 'in:Low,Medium,High'],
            'status' => ['required', 'in:Pending,In-Progress,Done'],
        ]);

        $department = Department::findOrFail($validated['department_id']);

        $task = $department->tasks()->create(
            Arr::only($validated, ['title', 'due_date', 'due_time', 'priority', 'status'])
        );

        return response()->json([
            'message' => 'Task created successfully.',
            'data' => $task->load('department'),
        ], 201);
    }

    public function updateStatus(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Pending,In-Progress,Done'],
        ]);

        $newStatus = $validated['status'];

        if ($task->status === $newStatus) {
            return response()->json([
                'message' => 'Status unchanged.',
                'data' => $task->fresh('department'),
            ]);
        }

        $task->update(['status' => $newStatus]);

        return response()->json([
            'message' => 'Task status updated successfully.',
            'data' => $task->fresh('department'),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        if ($task->status !== 'Done') {
            return response()->json([
                'message' => 'Only tasks with status Done can be deleted.',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }
}
