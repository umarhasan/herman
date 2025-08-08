@extends('admin.layouts.app')

@section('title', 'Users Management System')

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-6">
                        <h3 class="m-0">Users Management</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="usermanagesec">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">All Users</h5>
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.users.create') }}">
                                        <i class="fas fa-plus"></i> Invite New User
                                    </a>
                                </div>

                                {{-- Success Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Error Message --}}
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Users Table --}}
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @foreach ($user->getRoleNames() as $role)
                                                            <span class="badge bg-success">{{ ucfirst($role) }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td class="d-flex flex-wrap gap-1">
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('admin.users.edit', $user->id) }}"
                                                            title="Edit">
                                                            <i class="fas fa-pen"></i>
                                                        </a>

                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')"><i class="fa fa-trash"></i></button>
                                                        </form>

                                                        @if ($user->hasRole('Teacher'))
                                                            <button
                                                                type="button"
                                                                class="btn btn-warning btn-sm changeStatusBtn"
                                                                data-id="{{ $user->teacher->id ?? '' }}"
                                                                data-status="{{ $user->teacher->status ?? 0 }}">
                                                                Change Status
                                                            </button>
                                                            <a href="{{ route('admin.assignments.create', $user->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                Assign Subjects
                                                            </a>

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Teacher Status Modal -->
<div class="modal fade" id="teacherStatusModal" tabindex="-1" aria-labelledby="teacherStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="teacherStatusForm" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="teacherStatusModalLabel">Change Teacher Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="teacher_id" id="teacher_id">

            <div class="mb-3">
              <label for="status" class="form-label">Select Status</label>
              <select name="status" id="status" class="form-select" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Status</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.changeStatusBtn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                let teacherId = this.dataset.id;
                let status = this.dataset.status;

                document.getElementById('teacher_id').value = teacherId;
                document.getElementById('status').value = status;

                // Set form action dynamically
                document.getElementById('teacherStatusForm').action = '/admin/teachers/' + teacherId + '/status';

                var modal = new bootstrap.Modal(document.getElementById('teacherStatusModal'));
                modal.show();
            });
        });
    });
    </script>
@endsection
