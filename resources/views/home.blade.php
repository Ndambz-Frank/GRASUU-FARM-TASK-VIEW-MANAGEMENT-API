@extends('grasuulayout')
@section('content')
    <div class="container-fluid">
        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white">
                <h1 class="h4 mb-0">All tasks</h1>
                <p class="small mb-0 opacity-75">
                    NOTE: You can only delete DONE tasks. Update the status of the task before deleting it.
                </p>
            </div>
            <div class="card-body p-0">
                @if($tasks->isEmpty())
                    <p class="text-muted mb-0 p-4">No tasks yet. Create departments, then add tasks from each department page.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>Department</th>
                                    <th style="width: 90px;">Task ID</th>
                                    <th>Task title</th>
                                    <th>Due date</th>
                                    <th style="width: 100px;">Due time</th>
                                    <th style="width: 110px;">Priority</th>
                                    <th style="width: 170px;">Status</th>
                                    <th style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    @php $st = $task->status; @endphp
                                    <tr>
                                        <td>
                                            @if($task->department)
                                                <a href="{{ route('departments.show', $task->department) }}" class="text-success text-decoration-none">
                                                    {{ $task->department->name }}
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>{{ $task->id }}</td>
                                        <td>
                                            @if($task->department)
                                                <a href="{{ route('departments.tasks.show', [$task->department, $task]) }}" class="text-decoration-none">
                                                    {{ $task->title }}
                                                </a>
                                            @else
                                                {{ $task->title }}
                                            @endif
                                        </td>
                                        <td>{{ $task->due_date?->format('M j, Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::substr((string) $task->due_time, 0, 5) }}</td>
                                        <td>{{ $task->priority }}</td>
                                        <td>
                                            <select class="form-select form-select-sm task-status-select" data-task-id="{{ $task->id }}">
                                                <option value="Pending" @selected($st === 'Pending')>Pending</option>
                                                <option value="In-Progress" @selected($st === 'In-Progress')>In-Progress</option>
                                                <option value="Done" @selected($st === 'Done')>Done</option>
                                            </select>
                                        </td>
                                        <td class="text-nowrap">
                                            <button type="button"
                                                    class="btn btn-sm btn-success task-status-update"
                                                    data-task-id="{{ $task->id }}">
                                                Update
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger task-delete-api"
                                                    data-task-id="{{ $task->id }}"
                                                    @disabled($st !== 'Done')
                                                    @if($st !== 'Done') title="Mark the task as Done before you can delete it." @endif>
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
