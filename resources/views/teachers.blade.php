@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
<style>
  body {
    background-color: #f8f9fa;
  }
  .hero-title {
    font-size: 2.8rem;
    font-weight: 700;
    color: #1a1a1a;
  }
  .hero-title span {
    color: #0d6efd;
  }
  .teacher-card {
    border-radius: 1rem;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    position: relative;
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .btn-group-top {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
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
  .search-bar input {
    border-radius: 50px 0 0 50px;
    border: 1px solid #ddd;
  }
  .search-bar button {
    border-radius: 0 50px 50px 0;
  }
  .inner-pg-main .secTec {
    padding: 46px 1px;
    background-color: #cc9304;
}
</style>
<div class="inner-pg-main">
<section class="secTec">
    <div class="secTec-main">
        <h2 class="bann-head">Teacher</h2>
    </div>
</section>
<div class="container py-5">


  {{-- 👨‍🏫 Teachers Listing --}}
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
                <h5 class="mb-0 fw-bold">{{ $teacher->user->name }}</h5>
                <small class="text-muted">United States</small>
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

            <div class="d-flex flex-wrap gap-2">
              @if($teacher->video_url)
                <a href="{{ $teacher->video_url }}" target="_blank" class="btn btn-outline-secondary btn-sm shadow-sm">🎥 Watch Intro</a>
              @endif
              <a href="#" class="btn btn-success btn-sm shadow-sm">📅 Book / Chat</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  {{-- 💬 Reviews Section --}}
  <div class="text-center mt-5">
    <h4 class="fw-bold">💬 Read what students think!</h4>
    <p class="text-muted">Reviews and ratings coming soon.</p>
  </div>
</div>
</div>
@endsection
