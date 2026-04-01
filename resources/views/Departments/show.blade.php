@extends('grasuulayout')
@section('content')
    <div class="container">
        <div class="card border-success shadow-sm mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h2 class="h4 mb-0">{{ $department->name }}</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('departments.index') }}" class="btn btn-sm btn-light">All departments</a>
                    <a href="{{ route('departments.tasks.create', $department) }}" class="btn btn-sm btn-warning text-dark fw-semibold">
                        + Add task
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($department->tasks->isEmpty())
                    <p class="text-muted mb-0 p-4">No tasks yet. Create one to track work for this department.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th style="width: 48px;">#</th>
                                    <th>Title</th>
                                    <th>Due date</th>
                                    <th>Time</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($department->tasks as $task)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->due_date?->format('M j, Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::substr((string) $task->due_time, 0, 5) }}</td>
                                        <td>{{ $task->priority }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>
                                            <a href="{{ route('departments.tasks.show', [$department, $task]) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('departments.tasks.edit', [$department, $task]) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm task-delete-api"
                                                    data-task-id="{{ $task->id }}"
                                                    @disabled($task->status !== 'Done')
                                                    @if($task->status !== 'Done') title="Mark the task as Done before you can delete it." @endif>
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
