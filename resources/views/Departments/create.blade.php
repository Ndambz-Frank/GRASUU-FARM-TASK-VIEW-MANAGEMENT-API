@extends('grasuulayout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2>CREATE DEPARTMENT</h2>
                        <form id="department-create-form" action="{{ route('api.department.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.getElementById('department-create-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const res = await fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form),
        });
        const data = await res.json().catch(function () { return {}; });
        if (res.ok) {
            window.location.href = @json(route('departments.index'));
            return;
        }
        if (data.errors) {
            alert(Object.values(data.errors).flat().join('\n'));
            return;
        }
        alert(data.message || 'Could not create department');
    });
</script>
@endpush
