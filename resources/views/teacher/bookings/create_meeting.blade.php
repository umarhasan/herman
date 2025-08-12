@extends('teacher.layouts.app')

@section('title','Create Meeting')
@section('content')
<div class="container py-4">
  <h3>Create Meeting for Booking #{{ $booking->id }}</h3>

  <form action="{{ route('teacher.bookings.storeMeeting', $booking->id) }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Zoom Join URL</label>
      <input type="url" name="join_url" class="form-control" placeholder="https://zoom.us/j/xxxx" value="{{ $booking->zoom_join_url }}">
    </div>
    <div class="mb-3">
      <label>Zoom Meeting ID (optional)</label>
      <input type="text" name="zoom_meeting_id" class="form-control" value="{{ $booking->zoom_meeting_id }}">
    </div>
    <button class="btn btn-primary">Save Meeting</button>
  </form>

  <hr>

  <h5 class="mt-4">Upload Recorded Video (after class)</h5>
  <form action="{{ route('teacher.bookings.uploadRecording', $booking->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
      <label>Recording title (optional)</label>
      <input type="text" name="title" class="form-control">
    </div>
    <div class="mb-2">
      <label>Video file (mp4, mov, avi)</label>
      <input type="file" name="recording" accept="video/*" class="form-control" required>
    </div>
    <button class="btn btn-success">Upload Recording</button>
  </form>

  <hr>

  <h5>Existing Recordings</h5>
  @foreach($booking->recordings as $rec)
    <div class="mb-3">
      <strong>{{ $rec->title }}</strong><br>
      <video controls width="480">
        <source src="{{ asset('storage/'.$rec->file_url) }}" type="video/mp4">
      </video>

      <form action="{{ route('teacher.recordings.remove', $rec->id) }}" method="POST" style="display:inline-block;margin-top:6px;">
        @csrf
        <button class="btn btn-sm btn-danger" onclick="return confirm('Remove this recording?')">Remove</button>
      </form>
    </div>
  @endforeach
</div>
@endsection
