@extends('admin.layouts.app')


@section('title', 'Edit TimeTable')


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

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('admin.timetables.update', $timetable->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Teacher -->
                                    <div class="form-group mb-3">
                                        <label>Teacher</label>
                                        <select name="teacher_id" id="teacherDropdown" class="form-control" required>
                                            <option value="">Select Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    {{ $timetable->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Class -->
                                    <div class="form-group mb-3">
                                        <label>Class</label>
                                        <select name="school_class_id" id="classDropdown" class="form-control" required>
                                            <option value="">Select Class</option>
                                        </select>
                                        @error('school_class_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Subject -->
                                    <div class="form-group mb-3">
                                        <label>Subject</label>
                                        <select name="subject_id" id="subjectDropdown" class="form-control" required>
                                            <option value="">Select Subject</option>
                                        </select>
                                        @error('subject_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Day -->
                                    <div class="form-group mb-3">
                                        <label>Day</label>
                                        <select name="day" class="form-control" required>
                                            <option value="">Select WeekDay</option>
                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                                <option value="{{ $day }}"
                                                    {{ $timetable->day == $day ? 'selected' : '' }}>{{ $day }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('day')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Start Time -->
                                    <div class="form-group mb-3">
                                        <label>Start Time</label>
                                        <input type="time" name="start_time" class="form-control"
                                            value="{{ old('start_time', \Carbon\Carbon::parse($timetable->start_time)->format('H:i')) }}"
                                            required>
                                        @error('start_time')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- End Time -->
                                    <div class="form-group mb-3">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control"
                                            value="{{ old('end_time', \Carbon\Carbon::parse($timetable->end_time)->format('H:i')) }}"
                                            required>
                                        @error('end_time')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Update Entry</button>
                                        <a href="{{ route('admin.timetables.index') }}"
                                            class="btn btn-secondary btn-sm mb-2">
                                            <i class="fas fa-arrow-left"></i> Back
                                        </a>
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
        let selectedClass = "{{ $timetable->school_class_id }}";
        let selectedSubject = "{{ $timetable->subject_id }}";

        $(document).ready(function() {
            // Teacher dropdown change or page load
            $('#teacherDropdown').on('change', function() {
                let teacherId = $(this).val();
                console.log("Selected Teacher ID:", teacherId);

                $('#classDropdown').empty().append('<option value="">Select Class</option>');
                $('#subjectDropdown').empty().append('<option value="">Select Subject</option>');

                if (teacherId) {
                    $.get('/admin/get-classes-subjects-by-teacher/' + teacherId, function(data) {
                        console.log("Fetched Data for Teacher:", data);

                        $.each(data, function(classId, classData) {
                            let selected = classId == selectedClass ? 'selected' : '';
                            $('#classDropdown').append(
                                `<option value="${classId}" ${selected}>${classData.class_name}</option>`
                            );
                        });

                        // Save subject data for the selected class
                        $('#classDropdown').data('subjects', data);

                        // Automatically trigger class dropdown change to load subjects
                        $('#classDropdown').val(selectedClass).trigger('change');
                    }).fail(function(xhr, status, error) {
                        console.error("Error fetching class/subject data:", error);
                        console.log("Response:", xhr.responseText);
                    });
                }
            });

            // Class dropdown change
            $('#classDropdown').on('change', function() {
                let classId = $(this).val();
                let subjectsData = $(this).data('subjects');

                console.log("Selected Class ID:", classId);
                console.log("Subjects Data:", subjectsData);

                $('#subjectDropdown').empty().append('<option value="">Select Subject</option>');

                if (subjectsData && subjectsData[classId]) {
                    $.each(subjectsData[classId].subjects, function(index, subject) {
                        let selected = subject.id == selectedSubject ? 'selected' : '';
                        $('#subjectDropdown').append(
                            `<option value="${subject.id}" ${selected}>${subject.name}</option>`
                        );
                    });
                    console.log("Subject dropdown populated with:", subjectsData[classId].subjects);
                } else {
                    console.warn("No subjects found for class ID:", classId);
                }
            });

            // Initial load trigger
            $('#teacherDropdown').trigger('change');
        });
    </script>
@endsection
