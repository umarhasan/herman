@extends('admin.layouts.app')

@section('title', 'Edit Users')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Users Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="usermanagesec">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                            value="{{ $user->name }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                            value="{{ $user->email }}">
                                    </div>
                                    {{-- Date of Birth --}}
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Enter Password">
                                            <span class="input-group-text" onclick="togglePasswordVisibility()"
                                                style="cursor: pointer;">
                                                <i class="fa fa-eye-slash" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Enter Confirm-Password">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Select Role</label>
                                        <select name="roles" id="roles" class="form-select" required>
                                            <option disabled value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3" id="class_select">
                                        <label>Assign Class</label>
                                        <select name="class_id" class="form-select">
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id', $user->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div id="student-selection" class="form-group mb-3"
                                        style="{{ $user->hasRole('Parent') ? '' : 'display:none' }}">
                                        <label>Select Students (for Parent)</label>
                                        <select name="student_ids[]" multiple class="form-select">
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}"
                                                    @if (!empty($assignedChildren) && in_array($student->id, $assignedChildren)) selected @endif>{{ $student->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm mb-2">Update User</button>
                                    <a class="btn btn-secondary btn-sm mb-2" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.querySelector('select[name="roles"]').addEventListener('change', function() {
            document.getElementById('student_select').style.display = (this.value === 'parent') ? 'block' : 'none';
        });
    </script>
    <script>
        function toggleFields(role) {
            role = role.toLowerCase();

            document.getElementById('student-selection').style.display = (role === 'parent') ? 'block' : 'none';
            document.getElementById('class_select').style.display = (role === 'parent') ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.querySelector('select[name="roles"]');
            const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
            toggleFields(selectedRole);

            roleSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex].text;
                toggleFields(selected);
            });
        });
    </script>
@endsection
