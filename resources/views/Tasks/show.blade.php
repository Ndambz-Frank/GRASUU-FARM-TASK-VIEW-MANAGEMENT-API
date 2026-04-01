@extends('grasuulayout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">{{ $department->name }}</div>
                            <h2 class="h5 mb-0">{{ $task->title }}</h2>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('departments.tasks.edit', [$department, $task]) }}" class="btn btn-sm btn-light">Edit</a>
                            <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-outline-light">Department</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Due date</dt>
                            <dd class="col-sm-9">{{ $task->due_date?->format('M j, Y') }}</dd>
                            <dt class="col-sm-3">Due time</dt>
                            <dd class="col-sm-9">{{ \Illuminate\Support\Str::substr((string) $task->due_time, 0, 5) }}</dd>
                            <dt class="col-sm-3">Priority</dt>
                            <dd class="col-sm-9">{{ $task->priority }}</dd>
                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">{{ $task->status }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
