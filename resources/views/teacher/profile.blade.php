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

        {{-- Teacher Fields --}}
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
       <div class="mb-3">
            <label class="form-label">Topic</label>
            <input type="text" name="topic" class="form-control"
                value="{{ old('topic', $teacher->topic ?? '') }}">
        </div>
        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
    </form>
</div>

@endsection
