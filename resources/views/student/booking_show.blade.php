@extends('student.layouts.app')

@section('title','Booking #'.$booking->id)
@section('content')
<div class="container py-4">
  <h3>Booking #{{ $booking->id }}</h3>
  <p><strong>Teacher:</strong> {{ $booking->teacher->name ?? '-' }}</p>
  <p><strong>Topic:</strong> {{ $booking->topic ?? '-' }}</p>
  <p><strong>Status:</strong> {{ $booking->status }}</p>

  @if($booking->status === 'payment_link_sent')
    <p><a href="{{ $booking->payment_link }}" target="_blank" class="btn btn-primary">Open Payment Link</a></p>

    <form action="{{ route('bookings.uploadProof', $booking->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-2">
        <label>Upload Payment Proof (screenshot)</label>
        <input type="file" name="proof" accept="image/*" required class="form-control">
      </div>
      <button class="btn btn-success">Upload Proof</button>
    </form>
  @endif

  @if($booking->zoom_join_url)
    <p class="mt-3"><a href="{{ $booking->zoom_join_url }}" target="_blank" class="btn btn-outline-primary">Join Zoom</a></p>
  @endif

  <h4 class="mt-4">Recordings</h4>
  @forelse($booking->recordings as $rec)
    <div class="mb-3">
      <strong>{{ $rec->title }}</strong><br>
      @if($rec->file_type === 'local')
        <video controls width="640">
          <source src="{{ asset('storage/'.$rec->file_url) }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      @else
        <a href="{{ $rec->file_url }}" target="_blank">Open Recording</a>
      @endif
    </div>
  @empty
    <p>No recordings yet.</p>
  @endforelse

</div>
@endsection
