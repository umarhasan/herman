@extends('teacher.layouts.app')

@section('title', 'Edit TimeTable')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('teacher.timetables.update', $timetable->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Teacher --}}
                    <div class="form-group mb-3">
                        <label>Teacher</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        <input type="hidden" name="teacher_id" value="{{ $user->id }}">
                    </div>

                    {{-- Class --}}
                    <div class="form-group mb-3">
                        <label>Class</label>
                        <select name="school_class_id" id="classDropdown" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach ($classSubjects as $classId => $classData)
                                <option value="{{ $classId }}" {{ $timetable->school_class_id == $classId ? 'selected' : '' }}>
                                    {{ $classData['class_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Subject --}}
                    <div class="form-group mb-3">
                        <label>Subject</label>
                        <select name="subject_id" id="subjectDropdown" class="form-control" required>
                            <option value="">Select Subject</option>
                            @if(isset($classSubjects[$timetable->school_class_id]['subjects']))
                                @foreach ($classSubjects[$timetable->school_class_id]['subjects'] as $subject)
                                    <option value="{{ $subject['id'] }}" {{ $timetable->subject_id == $subject['id'] ? 'selected' : '' }}>
                                        {{ $subject['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Day --}}
                    <div class="form-group mb-3">
                        <label>Day</label>
                        <select name="day" class="form-control" required>
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                <option value="{{ $day }}" {{ $timetable->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Time --}}
                    <div class="form-group mb-3">
                        <label>Start Time</label>
                        <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($timetable->start_time)->format('H:i') }}" class="form-control" required>
                    </div>

                    {{-- End Time --}}
                    <div class="form-group mb-3">
                        <label>End Time</label>
                        <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($timetable->end_time)->format('H:i') }}" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update Entry</button>
                    <a href="{{ route('teacher.timetables.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </section>
</div>

<script>
    let allClassSubjects = @json($classSubjects);

    document.getElementById('classDropdown').addEventListener('change', function() {
        let classId = this.value;
        let subjectDropdown = document.getElementById('subjectDropdown');
        subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

        if (classId && allClassSubjects[classId]) {
            allClassSubjects[classId].subjects.forEach(function(subject) {
                let option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectDropdown.appendChild(option);
            });
        }
    });
</script>
@endsection
