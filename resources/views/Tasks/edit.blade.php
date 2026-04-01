@extends('grasuulayout')
@section('content')
    @php
        $dueTimeOld = old('due_time');
        if ($dueTimeOld === null && $task->due_time) {
            $dueTimeOld = \Illuminate\Support\Str::substr((string) $task->due_time, 0, 5);
        }
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">Edit task — {{ $department->name }}</h2>
                        <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-light">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.tasks.update', [$department, $task]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                                       class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="due_date" class="form-label">Due date</label>
                                    <input type="date" name="due_date" id="due_date"
                                           value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                                           class="form-control @error('due_date') is-invalid @enderror" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="due_time" class="form-label">Due time</label>
                                    <input type="time" name="due_time" id="due_time" value="{{ $dueTimeOld }}"
                                           class="form-control @error('due_time') is-invalid @enderror" required>
                                    @error('due_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                        <option value="Low" @selected(old('priority', $task->priority) === 'Low')>Low</option>
                                        <option value="Medium" @selected(old('priority', $task->priority) === 'Medium')>Medium</option>
                                        <option value="High" @selected(old('priority', $task->priority) === 'High')>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Pending" @selected(old('status', $task->status) === 'Pending')>Pending</option>
                                        <option value="In-Progress" @selected(old('status', $task->status) === 'In-Progress')>In-Progress</option>
                                        <option value="Done" @selected(old('status', $task->status) === 'Done')>Done</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
