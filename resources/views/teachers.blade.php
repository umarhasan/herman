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
  .rate-badge {
    background: #ffe7d9;
    color: #ff5722;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
  }

  /* WhatsApp Chat Styles */
  .chat-box {
    background: #ece5dd;
    padding: 15px;
    height: 400px;
    overflow-y: auto;
    border-radius: 10px;
  }
  .chat-bubble {
    max-width: 70%;
    padding: 10px 14px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.4;
    box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  }
  .chat-bubble-me {
    background: #dcf8c6;
    border-bottom-right-radius: 2px;
    text-align: left;
  }
  .chat-bubble-other {
    background: #fff;
    border-bottom-left-radius: 2px;
    text-align: left;
    border: 1px solid #e0e0e0;
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

            <h6>{{ $teacher->topic ?? 'No topic specified' }}</h6>
            <p class="text-muted small mb-2">
              {{ Str::limit($teacher->bio ?? 'No description provided.', 100) }}
            </p>

            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="rate-badge">💲{{ $teacher->hourly_rate ?? 'N/A' }}/hr</span>
            </div>

            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary btn-sm" style="display:flex; align-items:center; height:32px"
                   data-bs-toggle="modal" data-bs-target="#teacherProfile{{ $teacher->id }}">
                    👤 Profile
                </a>

                @role('Student')
                <a href="javascript:void(0)"
                   class="btn btn-outline-success btn-sm position-relative chat-btn"
                   data-bs-toggle="modal"
                   data-bs-target="#teacherChat{{ $teacher->user_id }}"
                   data-id="{{ $teacher->user_id }}">
                   💬 Chat
                   <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger unread-{{ $teacher->user_id }}" style="display:none">0</span>
                </a>
                @endrole

                <form action="{{ route('bookings.start', $teacher->user->id) }}" method="POST" class="d-inline" style="margin:0">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm" style="display:flex; align-items:center; gap:5px; height:32px">
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
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Profile - {{ $teacher->user->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p><strong>Topic:</strong> {{ $teacher->topic ?? 'N/A' }}</p>
                <p><strong>Bio:</strong> {{ $teacher->bio ?? 'N/A' }}</p>
                <p><strong>Hourly Rate:</strong> {{ $teacher->hourly_rate ?? 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Modal -->
        <div class="modal fade" id="teacherChat{{ $teacher->user_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">

                <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-comments me-2"></i> Chat with {{ $teacher->user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">
                <div id="chat-box-{{ $teacher->user->id }}" class="chat-box">
                    <div class="text-muted text-center mt-5">Loading chat...</div>
                </div>
                </div>

                <div class="modal-footer p-2 bg-light">
                <form class="chat-form w-100 d-flex" data-teacher="{{ $teacher->user->id }}">
                    @csrf
                    <input type="text"
                            name="message"
                            class="form-control rounded-pill me-2"
                            placeholder="Type a message..." required>
                    <button class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-paper-plane"></i>
                    </button>
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
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Load chat
    $('[id^="teacherChat"]').on('show.bs.modal', function () {
        const modal = $(this);
        const teacherId = modal.attr('id').replace('teacherChat','');
        const chatBox = $('#chat-box-' + teacherId);
        chatBox.html('<div class="text-muted text-center">Loading...</div>');

        $.get("{{ url('/student/chat') }}/" + teacherId)
            .done(function(data) {
                chatBox.html('');
                data.forEach(m => {
                    const isMine = (m.sender_id == {{ auth()->id() }});
                    const bubbleClass = isMine ? 'chat-bubble-me' : 'chat-bubble-other';
                    chatBox.append(`
                        <div class="d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'} mb-2">
                            <div class="chat-bubble ${bubbleClass}">
                                ${m.message}
                            </div>
                        </div>
                    `);
                });
                chatBox.scrollTop(chatBox[0].scrollHeight);
            })
            .fail(() => chatBox.html('<div class="text-danger">Failed to load messages.</div>'));
    });

    // Send msg
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
                chatBox.append(`
                    <div class="d-flex justify-content-end mb-2">
                        <div class="chat-bubble chat-bubble-me">${data.message}</div>
                    </div>
                `);
                chatBox.scrollTop(chatBox[0].scrollHeight);
                input.val('');
            })
            .fail(() => alert('Unable to send message.'));
    });

    // Realtime via Echo
    window.Echo.private('chat.{{ auth()->id() }}')
        .listen('MessageSent', e => {
            let from = e.sender_id;
            const chatBoxOpen = $('#chat-box-' + from);

            if (from) {
                let span = document.querySelector(`.unread-${from}`);
                if (span) {
                    let count = parseInt(span.innerText) || 0;
                    span.innerText = count + 1;
                    span.style.display = 'inline-block';
                }
            }

            if (chatBoxOpen.length) {
                chatBoxOpen.append(`
                    <div class="d-flex justify-content-start mb-2">
                        <div class="chat-bubble chat-bubble-other">${e.message}</div>
                    </div>
                `);
                chatBoxOpen.scrollTop(chatBoxOpen[0].scrollHeight);
            }
        });

    // Reset unread on open
    $('[id^=teacherChat]').on('show.bs.modal', function(){
        let id = $(this).attr('id').replace('teacherChat','');
        fetch(`/chat/mark-as-read/${id}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        })
        .then(() => {
            const span = document.querySelector(`.unread-${id}`);
            if (span) { span.style.display = 'none'; span.innerText = '0'; }
        });
    });
});
</script>
@endpush

@endsection
