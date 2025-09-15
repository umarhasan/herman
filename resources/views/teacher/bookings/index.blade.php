@extends('teacher.layouts.app')

@section('title','Teacher Bookings')

@section('content')
<div class="container py-4">
    <h3>My Bookings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped" id="example">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Topic</th>
                <th>Status</th>
                <th>Payment Proof</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookings as $index => $b)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $b->student->name ?? '-' }}</td>
                <td>{{ $b->topic ?? '-' }}</td>
                <td>{{ $b->status }}</td>
                <td>
                    @if($b->payment_proof)
                        <a href="{{ asset('storage/'.$b->payment_proof) }}" target="_blank" class="btn btn-sm btn-info">View Proof</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    {{-- Send payment link --}}
                    @if($b->status === 'awaiting_payment')
                        <form action="{{ route('teacher.bookings.sendLink', $b->id) }}" method="POST" class="d-flex mb-1">
                            @csrf
                            <input name="payment_link" type="url" class="form-control form-control-sm me-2" placeholder="https://payment.link/..." required>
                            <button class="btn btn-sm btn-primary">Send Link</button>
                        </form>
                    @endif

                    {{-- Create meeting --}}
                    @if($b->status === 'payment_approved')
                        <a href="{{ route('teacher.bookings.createMeeting', $b->id) }}" class="btn btn-sm btn-success mt-1">Create Meeting</a>
                    @endif

                    {{-- Manage / Upload recording --}}
                    @if(in_array($b->status, ['course_started','recording_uploaded']))
                        <a href="{{ route('teacher.bookings.createMeeting', $b->id) }}" class="btn btn-sm btn-secondary mt-1">Manage Meeting / Upload Recording</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

