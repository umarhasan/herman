@extends('teacher.layouts.app')

@section('title','Teacher Bookings')
@section('content')
<div class="container py-4">
  <h3>My Bookings</h3>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  @foreach($bookings as $b)
    <div class="card mb-2 p-3">
      <div class="row">
        <div class="col-md-8">
          <strong>Student:</strong> {{ $b->student->name ?? '-' }} <br>
          <strong>Topic:</strong> {{ $b->topic ?? '-' }} <br>
          <strong>Status:</strong> {{ $b->status }} <br>
          @if($b->payment_proof)
            <a href="{{ asset('storage/'.$b->payment_proof) }}" target="_blank" class="btn btn-sm btn-info mt-1">View Proof</a>
          @endif
        </div>
        <div class="col-md-4 text-end">
          @if($b->status === 'awaiting_payment')
            <form action="{{ route('teacher.bookings.sendLink', $b->id) }}" method="POST" class="d-flex">
              @csrf
              <input name="payment_link" type="url" class="form-control form-control-sm me-2" placeholder="https://payment.link/..." required>
              <button class="btn btn-sm btn-primary">Send Link</button>
            </form>
          @endif

          @if($b->status === 'payment_approved')
            <a href="{{ route('teacher.bookings.createMeeting', $b->id) }}" class="btn btn-sm btn-success mt-2">Create Meeting</a>
          @endif

          @if(in_array($b->status, ['course_started','recording_uploaded']))
            <a href="{{ route('teacher.bookings.createMeeting', $b->id) }}" class="btn btn-sm btn-secondary mt-2">Manage Meeting / Upload Recording</a>
          @endif
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
