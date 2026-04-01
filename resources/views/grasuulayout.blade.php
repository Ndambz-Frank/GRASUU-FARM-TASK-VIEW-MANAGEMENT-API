<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>GRASUU FARM TASK VIEW</title>
</head>
<body class="bg-success-subtle">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
        <div class="container-fluid justify-content-center">
            <span class="navbar-brand fw-bold mb-0 text-center display-6">GRASUU FARM TASK VIEW</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row min-vh-100">
            <aside class="col-12 col-md-3 col-lg-2 bg-light border-end py-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('home') }}" class="btn btn-success text-start">Home</a>
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle w-100 text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Departments
                        </button>
                        <ul class="dropdown-menu w-100 shadow-sm">
                            @forelse($sidebarDepartments ?? [] as $dept)
                                <li>
                                    <a class="dropdown-item" href="{{ route('departments.show', $dept) }}">
                                        {{ $dept->name }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted small">No departments yet</span></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('departments.index') }}">
                                    All departments
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-success text-start">
                        Reports
                    </a>
                </div>
            </aside>

            <main class="col-12 col-md-9 col-lg-10 py-4">
                @if(session('flash_message'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        {{ session('flash_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('flash_error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        {{ session('flash_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @hasSection('content')
                    @yield('content')
                @else
                    <div class="card border-success shadow-sm">
                        <div class="card-body">
                            <h4 class="text-success mb-3">Welcome</h4>
                            <p class="mb-0">
                                Select a created department from the sidebar to view farm tasks.
                            </p>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('click', async function (e) {
            const updateBtn = e.target.closest('.task-status-update');
            if (updateBtn && !updateBtn.disabled) {
                e.preventDefault();
                const id = updateBtn.getAttribute('data-task-id');
                const row = updateBtn.closest('tr');
                const sel = row ? row.querySelector('.task-status-select') : null;
                if (!sel || sel.disabled) return;
                const res = await fetch('/api/task/' + id + '/status', {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ status: sel.value }),
                });
                const data = await res.json().catch(function () { return {}; });
                if (res.ok) {
                    window.location.reload();
                    return;
                }
                var err = data.message;
                if (data.errors && data.errors.status) err = data.errors.status.join(' ');
                alert(err || 'Update failed');
                return;
            }
            const delBtn = e.target.closest('.task-delete-api');
            if (delBtn && !delBtn.disabled) {
                e.preventDefault();
                if (!confirm('Delete this task?')) return;
                const id = delBtn.getAttribute('data-task-id');
                const res = await fetch('/api/task/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json().catch(function () { return {}; });
                if (res.status === 403) {
                    alert(data.message || 'Forbidden');
                    return;
                }
                if (res.ok) {
                    window.location.reload();
                    return;
                }
                alert(data.message || 'Delete failed');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>