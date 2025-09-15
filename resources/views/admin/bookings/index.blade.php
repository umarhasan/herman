@extends('admin.layouts.app')

@section('title','All Bookings')

@section('content')
<div class="container py-4">
  <h3>All Bookings</h3>

  <table class="table table-bordered table-striped" id="example">
    <thead>
      <tr>
        <th>#</th>
        <th>Student</th>
        <th>Teacher</th>
        <th>Topic</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bookings as $index => $b)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $b->student->name ?? '-' }}</td>
        <td>{{ $b->teacher->name ?? '-' }}</td>
        <td>{{ $b->topic }}</td>
        <td>{{ $b->status }}</td>
        <td>
          <form action="{{ route('admin.bookings.approve', $b->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="btn btn-sm btn-success">Approve</button>
          </form>

          <form action="{{ route('admin.bookings.reject', $b->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="btn btn-sm btn-danger">Reject</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
