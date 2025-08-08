@extends('admin.layouts.app')


@section('title', 'Create TimeTable')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">TimeTable Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create TimeTable</li>
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

                                <form action="{{ route('admin.timetables.store') }}" method="POST">
                                    @csrf

                                    <!-- Teacher Select -->
                                    <div class="form-group mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="teacherDropdown" class="form-control" required>
                                            <option value="">Select Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Class Dropdown (filled by JS) -->
                                    <div class="form-group mb-3">
                                        <label>Class</label>
                                        <select name="school_class_id" id="classDropdown" class="form-control" required>
                                            <option value="">Select Class</option>
                                        </select>
                                    </div>

                                    <!-- Subject Dropdown (filled by JS) -->
                                    <div class="form-group mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="subjectDropdown" class="form-control" required>
                                            <option value="">Select Subject</option>
                                        </select>
                                    </div>

                                    <!-- Day -->
                                    <div class="form-group mb-3">
                                        <label>Day</label>
                                        <select name="day" class="form-control" required>
                                            <option value="">Select WeekDay</option>
                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                                <option value="{{ $day }}">{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Start Time -->
                                    <div class="form-group mb-3">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>

                                    <!-- End Time -->
                                    <div class="form-group mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Create Entry</button>
                                        <a href="{{ route('admin.timetables.index') }}"
                                            class="btn btn-secondary btn-sm mb-2"><i class="fas fa-arrow-left"></i> Back</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#teacherDropdown').on('change', function() {
            var teacherId = $(this).val();

            $('#classDropdown').empty().append('<option value="">Select Class</option>');
            $('#subjectDropdown').empty().append('<option value="">Select Subject</option>');

            if (teacherId) {
                $.get('/admin/get-classes-subjects-by-teacher/' + teacherId, function(data) {
                    console.log(data); // 🔍 Debug print
                    $.each(data, function(classId, classData) {
                        $('#classDropdown').append('<option value="' + classId + '">' + classData
                            .class_name + '</option>');
                    });

                    $('#classDropdown').data('subjects', data);
                });
            }
        });

        $('#classDropdown').on('change', function() {
            var classId = $(this).val();
            var subjectsData = $(this).data('subjects');

            $('#subjectDropdown').empty().append('<option value="">Select Subject</option>');

            if (subjectsData[classId]) {
                $.each(subjectsData[classId].subjects, function(index, subject) {
                    $('#subjectDropdown').append('<option value="' + subject.id + '">' + subject.name +
                        '</option>');
                });
            }
        });
    </script>
@endsection
