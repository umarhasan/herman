@extends('teacher.layouts.app')
@section('title', 'TimeTable Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">TimeTable Management</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">TimeTable Table</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="usermanagesec">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a class="btn btn-success btn-sm mb-2" href="{{ route('teacher.timetables.create') }}">
                                    <i class="fas fa-plus"></i> Add TimeTable
                                </a>

                                <div class="d-flex">
                                    <select id="bulk-action" class="form-select form-select-sm me-2" style="width:auto;">
                                        <option value="">Bulk Action</option>
                                        <option value="delete">Delete Selected</option>
                                    </select>
                                    <button id="apply-bulk-action" class="btn btn-primary btn-sm">Apply</button>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}</div>
                            @endif

                            <form id="bulk-action-form" method="POST">
                                @csrf
                                <input type="hidden" name="_method" id="bulk-method" value="">

                                <table border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>No</th>
                                            <th>Teacher</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Day</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($timetables as $t)
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="{{ $t->id }}" class="record-checkbox"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->teacher->name }}</td>
                                            <td>{{ $t->schoolClass->name }}</td>
                                            <td>{{ $t->subject->name }}</td>
                                            <td>{{ $t->day }}</td>
                                            <td>{{ $t->start_time }} - {{ $t->end_time }}</td>
                                            <td>
                                                <a href="{{ route('teacher.timetables.edit', $t->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No timetables found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Select/Deselect All
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('.record-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // Bulk Action Handler
    document.getElementById('apply-bulk-action').addEventListener('click', function () {
        let action = document.getElementById('bulk-action').value;
        let selected = Array.from(document.querySelectorAll('.record-checkbox:checked')).map(cb => cb.value);

        if (selected.length === 0) {
            alert('Please select at least one timetable.');
            return;
        }

        if (action === 'delete') {
            if (confirm('Are you sure you want to delete the selected timetables?')) {
                let form = document.getElementById('bulk-action-form');
                form.action = "{{ route('teacher.timetables.bulkDelete') }}";
                document.getElementById('bulk-method').value = 'DELETE';
                form.submit();
            }
        }
    });
</script>
@endsection
