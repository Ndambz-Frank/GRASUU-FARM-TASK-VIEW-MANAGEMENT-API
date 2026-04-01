@extends('grasuulayout')
@section('content')
    <div class="container-fluid">
        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="h4 mb-0">Task report by due date</h1>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="report-date" class="small mb-0 fw-semibold">Date</label>
                    <input type="date" id="report-date" name="report_date"
                           value="{{ now()->format('Y-m-d') }}"
                           class="form-control form-control-sm bg-white text-dark" style="width: auto;">
                    <button type="button" id="report-load" class="btn btn-sm btn-light">Load report</button>
                </div>
            </div>
            <div class="card-body">
                <p id="report-message" class="text-success fw-semibold mb-3"></p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <h2 class="h6 text-success">By priority</h2>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-success">
                                    <tr><th>Priority</th><th class="text-end">Count</th></tr>
                                </thead>
                                <tbody id="report-by-priority"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="h6 text-success">By status</h2>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-success">
                                    <tr><th>Status</th><th class="text-end">Count</th></tr>
                                </thead>
                                <tbody id="report-by-status"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="small text-muted mt-3 mb-0"><span id="report-total-label"></span></p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    (function () {
        function esc(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        }

        function fillTable(tbodyId, obj) {
            var tbody = document.getElementById(tbodyId);
            tbody.innerHTML = '';
            Object.keys(obj).forEach(function (key) {
                var tr = document.createElement('tr');
                tr.innerHTML = '<td>' + esc(key) + '</td><td class="text-end">' + esc(String(obj[key])) + '</td>';
                tbody.appendChild(tr);
            });
        }

        async function loadReport() {
            var dateInput = document.getElementById('report-date');
            var date = dateInput.value;
            if (!date) {
                alert('Please choose a date.');
                return;
            }
            var url = '/api/tasks/report?date=' + encodeURIComponent(date);
            var res = await fetch(url, { headers: { Accept: 'application/json' } });
            var data = await res.json().catch(function () { return {}; });

            if (!res.ok) {
                document.getElementById('report-message').textContent = data.message || 'Could not load report.';
                document.getElementById('report-by-priority').innerHTML = '';
                document.getElementById('report-by-status').innerHTML = '';
                document.getElementById('report-total-label').textContent = '';
                return;
            }

            document.getElementById('report-message').textContent = data.message || '';
            fillTable('report-by-priority', data.by_priority || {});
            fillTable('report-by-status', data.by_status || {});
            document.getElementById('report-total-label').textContent =
                'Total tasks due on ' + (data.date || date) + ': ' + (data.total_tasks != null ? data.total_tasks : '—');
        }

        document.getElementById('report-load').addEventListener('click', loadReport);
        document.getElementById('report-date').addEventListener('change', loadReport);
        loadReport();
    })();
</script>
@endpush
