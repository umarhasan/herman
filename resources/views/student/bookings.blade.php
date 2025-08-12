@extends('student.layouts.app')

@section('title','My Bookings')
@section('content')
<div class="container py-4">
  <h3>My Bookings</h3>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  @forelse($bookings as $b)
    <div class="card mb-2 p-3">
      <div class="d-flex justify-content-between">
        <div>
          <strong>Teacher:</strong> {{ $b->teacher->name ?? $b->teacher->user->name ?? '-' }}<br>
          <strong>Topic:</strong> {{ $b->topic ?? '-' }}<br>
          <strong>Price:</strong> ${{ $b->price ?? 'N/A' }}<br>
          <strong>Status:</strong> <span class="badge bg-info">{{ $b->status }}</span>
        </div>
        <div class="text-end">
          <a href="{{ route('student.bookings.show', $b->id) }}" class="btn btn-sm btn-primary">View</a>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">You have no bookings.</div>
  @endforelse
</div>
@endsection
