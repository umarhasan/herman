@extends('teacher.layouts.app')

@section('title', 'Create TimeTable')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">TimeTable Management</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create TimeTable</li>
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

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('teacher.timetables.store') }}" method="POST">
                                @csrf

                                <!-- Teacher -->
                                <div class="form-group mb-3">
                                    <label>Teacher</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                    <input type="hidden" name="teacher_id" value="{{ $user->id }}">
                                </div>

                                <!-- Class -->
                                <div class="form-group mb-3">
                                    <label>Class</label>
                                    <select name="school_class_id" id="classDropdown" class="form-control" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classSubjects as $classId => $classData)
                                            <option value="{{ $classId }}">{{ $classData['class_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subject -->
                                <div class="form-group mb-3">
                                    <label>Subject</label>
                                    <select name="subject_id" id="subjectDropdown" class="form-control" required>
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>

                                <!-- Days & Time Slots -->
                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                @endphp

                                @foreach ($days as $day)
                                    <div class="day-section border p-3 mb-3">
                                        <h5>{{ $day }}</h5>
                                        <div id="timeSlotsWrapper-{{ $day }}">
                                            <div class="timeSlot row mb-2">
                                                <div class="col">
                                                    <input type="time" name="start_time[{{ $day }}][]" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <input type="time" name="end_time[{{ $day }}][]" class="form-control">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button" class="btn btn-danger removeSlot">X</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm addTimeSlot" data-day="{{ $day }}">+ Add More Time</button>
                                    </div>
                                @endforeach

                                <!-- Submit -->
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-success btn-sm mb-2">Create Entry</button>
                                    <a href="{{ route('teacher.timetables.index') }}" class="btn btn-secondary btn-sm mb-2">
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
    let classSubjects = @json($classSubjects);

    $(document).ready(function() {
        // Preselect first class & subject
        let firstClassId = Object.keys(classSubjects)[0];
        if (firstClassId) {
            $('#classDropdown').val(firstClassId);
            populateSubjects(firstClassId);
            let firstSubjectId = classSubjects[firstClassId]?.subjects?.[0]?.id;
            if (firstSubjectId) {
                $('#subjectDropdown').val(firstSubjectId);
            }
        }

        $('#classDropdown').on('change', function() {
            populateSubjects($(this).val());
        });

        function populateSubjects(classId) {
            let subjects = classSubjects[classId]?.subjects || [];
            $('#subjectDropdown').empty().append('<option value="">Select Subject</option>');
            subjects.forEach(function(subject) {
                $('#subjectDropdown').append(`<option value="${subject.id}">${subject.name}</option>`);
            });
        }

        // Add Time Slot per Day
        $(document).on('click', '.addTimeSlot', function() {
            let day = $(this).data('day');
            $(`#timeSlotsWrapper-${day}`).append(`
                <div class="timeSlot row mb-2">
                    <div class="col">
                        <input type="time" name="start_time[${day}][]" class="form-control">
                    </div>
                    <div class="col">
                        <input type="time" name="end_time[${day}][]" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger removeSlot">X</button>
                    </div>
                </div>
            `);
        });

        // Remove Slot
        $(document).on('click', '.removeSlot', function() {
            $(this).closest('.timeSlot').remove();
        });
    });
</script>
@endsection
