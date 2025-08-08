@extends('teacher.layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">✏️ Update Profile</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Personal Info --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control"
                       value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
            </div>
        </div>

        {{-- Profile Image --}}
        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>

        @if($user->profile_image)
            <div class="mb-3">
                <p><strong>Current Profile Image:</strong></p>
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" width="140" class="rounded mb-2">
            </div>
        @else
            <p><strong>Profile Image:</strong> Not uploaded</p>
        @endif

        {{-- Teacher fields --}}
        <div class="mb-3">
            <label class="form-label">Intro Video URL</label>
            <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $teacher->video_url ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Hourly Rate</label>
            <input type="text" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $teacher->hourly_rate ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $teacher->bio ?? '') }}</textarea>
        </div>

        {{-- Available Days --}}
        @php
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $selectedDays = is_array(optional($teacher)->available_days)
                            ? $teacher->available_days
                            : (json_decode(optional($teacher)->available_days, true) ?? []);
        @endphp

        <div class="mb-3">
            <label class="form-label">Available Days</label><br>
            @foreach ($days as $day)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="available_days[]"
                        value="{{ $day }}" id="day_{{ $day }}"
                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                    <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                </div>
            @endforeach
        </div>

        {{-- Assigned Classes & Subjects (read-only) --}}
        <div class="mb-4">
            <h5>📚 Assigned Classes & Subjects</h5>
            @forelse($classSubjects as $classId => $classData)
                <div class="mb-2">
                    <strong>{{ $classData['class_name'] ?? 'Class' }}</strong>
                    <ul class="mb-0">
                        @foreach($classData['subjects'] as $subject)
                            <li>{{ $subject['name'] ?? 'Subject' }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p>No classes assigned.</p>
            @endforelse
        </div>

        {{-- Timetable --}}
        <div class="mb-4">
            <h5>🗓 Timetable</h5>

            <button type="button" id="add-row" class="btn btn-success mb-3">+ Add Timetable Entry</button>

            <div id="timetable-wrapper">
                @if($timetable->isEmpty())
                    <p class="text-muted">No timetable entries yet. Click "Add Timetable Entry" to create one.</p>
                @else
                    @foreach($timetable as $day => $entries)
                        @foreach($entries as $entry)
                            <div class="row timetable-row mb-2 align-items-center">
                                <div class="col-md-3 mb-2">
                                    <select name="timetable[][day]" class="form-control">
                                        @foreach($days as $d)
                                            <option value="{{ $d }}" {{ $day == $d ? 'selected' : '' }}>{{ $d }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <select name="timetable[][subject_id]" class="form-control">
                                        @foreach($classSubjects as $classData)
                                            @foreach($classData['subjects'] as $subject)
                                                <option value="{{ $subject['id'] }}"
                                                    {{ $entry->subject_id == $subject['id'] ? 'selected' : '' }}>
                                                    {{ $classData['class_name'] ?? '' }} — {{ $subject['name'] ?? '' }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <input type="time" name="timetable[][start_time]" class="form-control" value="{{ \Carbon\Carbon::parse($entry->start_time)->format('H:i') }}">
                                </div>

                                <div class="col-md-2 mb-2">
                                    <input type="time" name="timetable[][end_time]" class="form-control" value="{{ \Carbon\Carbon::parse($entry->end_time)->format('H:i') }}">
                                </div>

                                <div class="col-md-1 mb-2">
                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>

            {{-- Hidden template data for JS --}}
            @php
                $subjectList = [];
                foreach($classSubjects as $classData){
                    foreach($classData['subjects'] as $subject){
                        $subjectList[] = [
                            'id' => $subject['id'],
                            'name' => $subject['name'] ?? '',
                            'class_name' => $classData['class_name'] ?? ''
                        ];
                    }
                }
            @endphp
        </div>

        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
    </form>
</div>

{{-- JS: add/remove timetable rows --}}
<script>
    (function(){
        const days = @json($days);
        const subjects = @json($subjectList);

        function buildDayOptions(selected = '') {
            return days.map(d => `<option value="${d}" ${d === selected ? 'selected' : ''}>${d}</option>`).join('');
        }

        function buildSubjectOptions(selectedId = '') {
            if (!subjects.length) {
                return '<option value="">No subjects available</option>';
            }
            return subjects.map(s => {
                const label = (s.class_name ? (s.class_name + ' — ') : '') + (s.name ?? '');
                return `<option value="${s.id}" ${s.id == selectedId ? 'selected' : ''}>${label}</option>`;
            }).join('');
        }

        function makeRow(day = '', subjectId = '', start = '', end = '') {
            const row = document.createElement('div');
            row.className = 'row timetable-row mb-2 align-items-center';
            row.innerHTML = `
                <div class="col-md-3 mb-2">
                    <select name="timetable[][day]" class="form-control">${buildDayOptions(day)}</select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="timetable[][subject_id]" class="form-control">${buildSubjectOptions(subjectId)}</select>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="time" name="timetable[][start_time]" class="form-control" value="${start}">
                </div>
                <div class="col-md-2 mb-2">
                    <input type="time" name="timetable[][end_time]" class="form-control" value="${end}">
                </div>
                <div class="col-md-1 mb-2">
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                </div>
            `;
            return row;
        }

        document.getElementById('add-row').addEventListener('click', function(){
            if (!subjects.length) {
                alert('No subjects available to add. Please contact admin or assign classes/subjects first.');
                return;
            }
            const wrapper = document.getElementById('timetable-wrapper');
            wrapper.appendChild(makeRow());
            wrapper.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'end' });
        });

        document.getElementById('timetable-wrapper').addEventListener('click', function(e){
            if (e.target && e.target.matches('button.remove-row')) {
                e.target.closest('.timetable-row').remove();
            }
        });
    })();
</script>
@endsection
