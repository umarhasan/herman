@extends('teacher.layouts.app')

@section('content')
<div class="container mt-4">



    {{-- 📝 Profile Update Form --}}
    <h4 class="mb-3">✏️ Update Profile</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Profile Image Upload --}}
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>
        @if($user->profile_image)
                <p><strong>Profile Image:</strong></p>
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" width="120" class="rounded mb-3">
            @else
                <p><strong>Profile Image:</strong> Not uploaded</p>
            @endif
        <div class="mb-3">
            <label>Intro Video URL</label>
            <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $teacher->video_url ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Hourly Rate</label>
            <input type="text" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $teacher->hourly_rate ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $teacher->bio ?? '') }}</textarea>
        </div>

        @php
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $selectedDays = is_array(optional($teacher)->available_days)
                        ? $teacher->available_days
                        : (json_decode(optional($teacher)->available_days, true) ?? []);
    @endphp

    <div class="mb-3">
        <label>Available Days</label><br>
        @foreach ($days as $day)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="available_days[]"
                    value="{{ $day }}" id="day_{{ $day }}"
                    {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
            </div>
        @endforeach
    </div>

        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
    </form>
</div>
@endsection
