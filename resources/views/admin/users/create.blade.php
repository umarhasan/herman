@extends('admin.layouts.app')

@section('title', 'Create Users')

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
                            <li class="breadcrumb-item active">New User</li>
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

                                <form action="{{ route('admin.users.store') }}" method="POST">
                                    @csrf

                                    {{-- Name --}}
                                    <div class="form-group mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                            required>
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                            required>
                                    </div>

                                    {{-- Password --}}
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Enter Password" required>
                                            <span class="input-group-text" onclick="togglePasswordVisibility()"
                                                style="cursor: pointer;">
                                                <i class="fa fa-eye-slash" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="form-group mb-3">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm Password" required>
                                    </div>
                                    {{-- Date of birth --}}
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" id="date_of_birth"
                                            placeholder="Enter Date of Birth" required>
                                    </div>
                                    {{-- Role --}}
                                    <div class="form-group mb-3">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-select" required>
                                            <option disabled selected value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Assign Subjects (only for teachers) --}}
                                    {{-- <div class="form-group mb-3" id="subject-section" style="display: none;">
                                        <label>Assign Subjects</label>
                                        <select name="subject_ids" class="form-select">
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    {{-- Class (Only for student/teacher) --}}
                                    <div class="form-group mb-3" id="class-section" style="display: none;">
                                        <label>Class</label>
                                        <select name="class_id" class="form-select">
                                            <option value="">Select Class (optional)</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Student assignment (Only for parent) --}}
                                    <div class="form-group mb-3" id="student-selection" style="display: none;">
                                        <label>Assign Student(s) (For Parent Role Only)</label>
                                        <select name="student_ids[]" id="studentsID" multiple class="form-select">
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Buttons --}}
                                    <button type="submit" class="btn btn-success btn-sm mb-2">Create User</button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm mb-2">
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
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#studentsID').select2({
                allowClear: true,
                width: '100%',
            });
        });
    </script>

    <script>
        const roleSelect = document.getElementById('role');
        const studentSection = document.getElementById('student-selection');
        const classSection = document.getElementById('class-section');

        // Map role IDs to role names (update these IDs based on your DB)
        const roleMap = {
            1: 'admin',
            2: 'teacher',
            3: 'student',
            4: 'parent'
        };

        function toggleFields() {
            const selectedId = roleSelect.value;
            const selectedRole = roleMap[selectedId];

            if (selectedRole === 'parent') {
                studentSection.style.display = 'block';
                classSection.style.display = 'none';
            } else if (selectedRole === 'teacher' || selectedRole === 'student') {
                classSection.style.display = 'block';
                studentSection.style.display = 'none';
            } else {
                studentSection.style.display = 'none';
                classSection.style.display = 'none';
            }
        }

        window.addEventListener('DOMContentLoaded', toggleFields);
        roleSelect.addEventListener('change', toggleFields);
    </script>


    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const role = this.options[this.selectedIndex].text.toLowerCase();

            // Show/hide based on role
            document.getElementById('class-section').style.display = (role === 'teacher' || role === 'student') ?
                'block' : 'none';
            document.getElementById('student-selection').style.display = (role === 'parent') ? 'block' : 'none';
            document.getElementById('subject-section').style.display = (role === 'teacher') ? 'block' : 'none';
            document.getElementById('class-assign-section').style.display = (role === 'teacher') ? 'block' : 'none';
        });
    </script>
@endsection
