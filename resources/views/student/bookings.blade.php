@extends('student.layouts.app')

@section('title','My Bookings')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">My Bookings</h3>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table id="example" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Teacher ID</th>
                    <th>Topic</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $b->teacher->name ?? $b->teacher->user->name ?? '-' }}</td>
                        <td>{{ $b->teacher->id ?? $b->teacher->user->id ?? '-' }}</td>
                        <td>{{ $b->topic ?? '-' }}</td>
                        <td>${{ $b->price ?? 'N/A' }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($b->status) }}</span></td>
                        <td>
                            <a href="{{ route('student.bookings.show', $b->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

