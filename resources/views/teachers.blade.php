@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
<style>
  body {
    background-color: #f8f9fa;
  }
  .teacher-card {
    border-radius: 1rem;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
  }
  .teacher-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
  }
  .teacher-image {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #0d6efd;
  }
  .availability-badge {
    background: #e9f5ff;
    color: #0d6efd;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
  }
  .rate-badge {
    background: #ffe7d9;
    color: #ff5722;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
  }
</style>

<div class="container py-5">
  @if($teachers->isEmpty())
    <div class="alert alert-info text-center shadow-sm">
      No teachers available at the moment.
    </div>
  @else
    <div class="row g-4">
      @foreach($teachers as $teacher)
        <div class="col-md-6 col-lg-4">
          <div class="teacher-card p-4 h-100">
            <div class="d-flex align-items-center mb-3">
              <img src="{{ $teacher->user->profile_image ? asset('storage/' . $teacher->user->profile_image) : asset('assets/images/profile-icon.jpg') }}" alt="{{ $teacher->user->name }}" class="teacher-image me-3">
              <div>
                <h5 class="mb-1 fw-bold">{{ $teacher->user->name }}</h5>
                <span class="badge bg-primary">{{ $teacher->topic ?? 'No topic specified' }}</span>
              </div>
            </div>
            <p class="text-muted small mb-2">{{ Str::limit($teacher->bio ?? 'No description provided.', 100) }}</p>

            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="availability-badge">
                Availability: {{ is_array($teacher->available_days) ? implode(', ', $teacher->available_days) : 'Not set' }}
              </span>
              <span class="rate-badge">
                ${{ $teacher->hourly_rate ?? 'N/A' }}/hr
              </span>
            </div>

            <a class="btn btn-danger btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#teacherModal{{ $teacher->id }}">
              📄 View Details
            </a>
            <a href="#" class="btn btn-success">📅 Book / Chat</a>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="teacherModal{{ $teacher->id }}" tabindex="-1" aria-labelledby="teacherModalLabel{{ $teacher->id }}" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="teacherModalLabel{{ $teacher->id }}">{{ $teacher->user->name }} - {{ $teacher->topic }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>Bio:</strong> {{ $teacher->bio ?? 'No bio available.' }}</p>
                <p><strong>Hourly Rate:</strong> ${{ $teacher->hourly_rate ?? 'N/A' }}</p>
                <p><strong>Available Days:</strong> {{ is_array($teacher->available_days) ? implode(', ', $teacher->available_days) : 'Not set' }}</p>

                <h6 class="mt-4">📅 Time Table</h6>
                @if(isset($teacher->timetables) && $teacher->timetables->count() > 0)
                  <table class="table table-bordered table-sm">
                    <thead>
                      <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($teacher->timetables as $time)
                        <tr>
                          <td>{{ $time->day }}</td>
                          <td>{{ $time->start_time }}</td>
                          <td>{{ $time->end_time }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  <p class="text-muted">No timetable available.</p>
                @endif
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
            </div>
          </div>
        </div>

      @endforeach
    </div>
  @endif
</div>
@endsection
