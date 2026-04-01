<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $departments = Department::query()->withCount('tasks')->orderBy('name')->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): View
    {
        $department->load([
            'tasks' => fn ($q) => $q->orderBy('due_date')->orderBy('due_time'),
        ]);

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
