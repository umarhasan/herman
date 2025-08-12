@extends('admin.layouts.app')

@section('title','All Bookings')
@section('content')
<div class="container py-4">
  <h3>All Bookings</h3>

  @foreach($bookings as $b)
    <div class="card mb-2 p-3">
      <div><strong>Student:</strong> {{ $b->student->name ?? '-' }}</div>
      <div><strong>Teacher:</strong> {{ $b->teacher->name ?? '-' }}</div>
      <div><strong>Topic:</strong> {{ $b->topic }}</div>
      <div><strong>Status:</strong> {{ $b->status }}</div>

      <form action="{{ route('admin.bookings.approve', $b->id) }}" method="POST" style="display:inline-block;">
        @csrf
        <button class="btn btn-sm btn-success mt-2">Approve</button>
      </form>

      <form action="{{ route('admin.bookings.reject', $b->id) }}" method="POST" style="display:inline-block;">
        @csrf
        <button class="btn btn-sm btn-danger mt-2">Reject</button>
      </form>
    </div>
  @endforeach
</div>
@endsection
