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
  .topic-badge {
    background: #d1ecf1;
    color: #0c5460;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
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
              <img src="{{ $teacher->user->profile_image ? asset('storage/' . $teacher->user->profile_image) : asset('assets/images/profile-icon.jpg') }}"
                   alt="{{ $teacher->user->name }}"
                   class="teacher-image me-3">
              <div>
                <h5 class="mb-1 fw-bold">{{ $teacher->user->name }}</h5>
              </div>
            </div>
            <h6>
                {{ $teacher->topic ?? 'No topic specified' }}
            </h6>
            <p class="text-muted small mb-2">
              {{ Str::limit($teacher->bio ?? 'No description provided.', 100) }}
            </p>

            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="rate-badge">
                💲{{ $teacher->hourly_rate ?? 'N/A' }}/hr
              </span>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary btn-sm"
                   style="display:flex; align-items:center; height:32px"
                   data-bs-toggle="modal"
                   data-bs-target="#teacherProfile{{ $teacher->id }}">
                    👤 Profile
                </a>

                @role('Student')
                <a href="javascript:void(0)"
                   class="btn btn-outline-success btn-sm"
                   data-bs-toggle="modal"
                   data-bs-target="#teacherChat{{ $teacher->user_id }}">
                   💬 Chat
                </a>
                @endrole

                <form action="{{ route('bookings.start', $teacher->user->id) }}"
                      method="POST"
                      class="d-inline"
                      style="margin:0">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm"
                        style="display:flex; align-items:center; gap:5px; height:32px">
                    <i class="fas fa-play"></i> Start Course
                </button>
                </form>
            </div>
          </div>
        </div>

        <!-- Profile Modal -->
        <div class="modal fade" id="teacherProfile{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body p-4">
                <div class="text-center mb-4">
                  <img src="{{ $teacher->user->profile_image ? asset('storage/' . $teacher->user->profile_image) : asset('assets/images/profile-icon.jpg') }}"
                       alt="{{ $teacher->user->name }}"
                       class="rounded-circle" width="120" height="120">
                  <h4 class="fw-bold mt-3">{{ $teacher->user->name }}</h4>
                  <h6>
                   {{ $teacher->topic ?? 'No topic specified' }}
                  </h6>
                </div>

                <p><strong>Bio:</strong> {{ $teacher->bio ?? 'No bio available.' }}</p>
                <p><strong>Hourly Rate:</strong> 💲{{ $teacher->hourly_rate ?? 'N/A' }}</p>
                <p><strong>Available Days:</strong> {{ is_array($teacher->available_days) ? implode(', ', $teacher->available_days) : 'Not set' }}</p>

                <h6 class="mt-4">📅 Time Table</h6>
                @if(isset($teacher->timetables) && $teacher->timetables->count() > 0)
                  <table class="table table-bordered table-sm">
                    <thead class="table-light">
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
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Modal -->
        <div class="modal fade" id="teacherChat{{ $teacher->user_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3">
                <h5 class="mb-3">Chat with {{ $teacher->user->name }}</h5>

                <div id="chat-box-{{ $teacher->user->id }}"
                    class="border rounded p-3 mb-3 bg-white"
                    style="height:300px;overflow-y:auto;">
                    <div class="text-muted">Loading chat...</div>
                </div>

                <form class="chat-form" data-teacher="{{ $teacher->user->id }}">
                    @csrf
                    <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                    <button class="btn btn-primary">Send</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>

      @endforeach
    </div>
  @endif
</div>
@push('scripts')
<script>
$(function() {
    // Setup jQuery ajax CSRF
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // When modal opens, fetch history
    $('[id^="teacherChat"]').on('show.bs.modal', function (e) {
        const modal = $(this);
        const teacherId = modal.attr('id').replace('teacherChat','');
        const chatBox = $('#chat-box-' + teacherId);
        chatBox.html('<div class="text-muted">Loading...</div>');

        $.get("{{ url('/student/chat') }}/" + teacherId)
            .done(function(data) {
                chatBox.html('');
                data.forEach(m => {
                    const who = (m.sender_id == {{ auth()->id() }}) ? 'You' : m.sender.name;
                    const align = (m.sender_id == {{ auth()->id() }}) ? 'text-end' : 'text-start';
                    chatBox.append(`<div class="${align} mb-2"><small><strong>${who}:</strong></small><div>${m.message}</div></div>`);
                });
                chatBox.scrollTop(chatBox[0].scrollHeight);
            })
            .fail(function() {
                chatBox.html('<div class="text-danger">Failed to load messages.</div>');
            });
    });

    // Send message
    $(document).on('submit', '.chat-form', function(e) {
        e.preventDefault();
        const form = $(this);
        const teacherId = form.data('teacher');
        const input = form.find('input[name=message]');
        const message = input.val().trim();
        if (!message) return;

        $.post("{{ url('/student/chat') }}/" + teacherId, { message })
            .done(function(data) {
                const chatBox = $('#chat-box-' + teacherId);
                chatBox.append(`<div class="text-end mb-2"><small><strong>You:</strong></small><div>${data.message}</div></div>`);
                chatBox.scrollTop(chatBox[0].scrollHeight);
                input.val('');
            })
            .fail(function() {
                alert('Unable to send message.');
            });
    });

    // Listen for incoming messages on private channel for authenticated user
    window.Echo.private('chat.{{ auth()->id() }}')
        .listen('MessageSent', (e) => {
            // e has message payload from broadcastWith
            const payload = e;
            const chatBox = $('#chat-box-' + payload.sender_id);
            // If chat box exists (modal open) append, else you may show a toast (optional)
            if (chatBox.length) {
                chatBox.append(`<div class="text-start mb-2"><small><strong>${payload.sender.name}:</strong></small><div>${payload.message}</div></div>`);
                chatBox.scrollTop(chatBox[0].scrollHeight);
            } else {
                // optional: notify user (e.g., using toast)
                console.log('New message from', payload.sender.name, payload.message);
            }
        });
});
</script>
@endpush

@endsection
