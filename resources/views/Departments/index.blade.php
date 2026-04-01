@extends('grasuulayout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">DEPARTMENTS</h2>
                        <a href="{{ url('/departments/create') }}" class="btn btn-success" title="Add New Department">
                            + Add Department
                        </a>
                    </div>
                    <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>
                                <th style="width: 100px;">Tasks</th>
                                <th style="width: 230px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->tasks_count }}</td>
                                <td>
                                    <a href="{{ url('/departments/' . $department->id) }}" class="btn btn-info btn-sm">
                                        View
                                    </a>
                                    <a href="{{ url('/departments/' . $department->id . '/edit') }}" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ url('/departments/' . $department->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this department?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection