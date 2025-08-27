@extends('layouts.app')

@section('title', 'Teacher Chats')

@section('content')
<style>
  body { background: #f0f2f5; }
  .chat-container {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  }
  .chat-sidebar {
    background: #fff;
    border-right: 1px solid #ddd;
    height: 500px;
    overflow-y: auto;
  }
  .chat-sidebar .list-group-item {
    cursor: pointer;
    border: none;
    border-bottom: 1px solid #f1f1f1;
    padding: 12px 15px;
    transition: background 0.2s;
  }
  .chat-sidebar .list-group-item:hover,
  .chat-sidebar .list-group-item.active {
    background: #5093f8;
  }
  .chat-box {
    background: #ece5dd;
    height: 500px;
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
  }
  .chat-bubble {
    max-width: 70%;
    padding: 10px 14px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.4;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    margin-bottom: 8px;
    word-wrap: break-word;
  }
  .chat-bubble-me {
    background: #dcf8c6;
    align-self: flex-end;
    border-bottom-right-radius: 2px;
  }
  .chat-bubble-other {
    background: #fff;
    align-self: flex-start;
    border-bottom-left-radius: 2px;
    border: 1px solid #e0e0e0;
  }
  .chat-footer {
    background: #fff;
    border-top: 1px solid #ddd;
    padding: 10px;
  }
</style>

<div class="container py-4">
  <h3 class="mb-4">💬 My Chats</h3>
  <div class="row chat-container bg-white">
    <!-- Sidebar -->
    <div class="col-md-4 p-0 chat-sidebar">
      <ul class="list-group" id="conversations-list">
        @foreach($conversations as $userId => $messages)
          @php
            $first = $messages->first();
            $other = ($first->sender_id == auth()->id()) ? $first->receiver : $first->sender;
          @endphp
          <li class="list-group-item d-flex justify-content-between align-items-center chat-user" data-user="{{ $other->id }}">
            <span class="chat-user-name fw-bold">{{ $other->name }}</span>
            <span class="badge bg-danger unread-{{ $other->id }}" style="display:none">0</span>
          </li>
        @endforeach
      </ul>
    </div>

    <!-- Chat Window -->
    <div class="col-md-8 p-0 d-flex flex-column">
      <div id="teacher-chat-box" class="chat-box">
        <div class="text-muted m-auto">👆 Select a student to start chatting</div>
      </div>

      <div class="chat-footer">
        <form id="teacher-chat-form" style="display:none;" class="d-flex">
          @csrf
          <input type="text" name="message" class="form-control rounded-pill me-2" placeholder="Type a message..." required>
          <button class="btn btn-success rounded-pill px-4">
            <i class="fas fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let currentUser = null;

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Load unread counts
    function loadUnreadCounts(){
        document.querySelectorAll('.chat-user').forEach(item=>{
            let id = item.dataset.user;
            fetch(`/chat/unread/${id}`)
                .then(r=>r.json())
                .then(d=>{
                    let span = document.querySelector(`.unread-${id}`);
                    if(d.count>0){
                        span.innerText = d.count;
                        span.style.display='inline-block';
                    } else {
                        span.style.display='none';
                    }
                });
        });
    }
    loadUnreadCounts();

    // Open chat
    $(document).on('click', '.chat-user', function(){
        $('.chat-user').removeClass('active');
        $(this).addClass('active');

        currentUser = $(this).data('user');
        $('#teacher-chat-form').show();

        fetch(`/chat/mark-as-read/${currentUser}`, {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
        $(`.unread-${currentUser}`).hide().text('0');

        loadMessages(currentUser);
    });

    function loadMessages(id){
        const box = $('#teacher-chat-box');
        box.html('<div class="text-muted">Loading...</div>');
        $.get("{{ url('/teacher/chat') }}/" + id)
            .done(function(data){
                box.html('');
                data.forEach(m=>{
                    const isMine = m.sender_id == {{ auth()->id() }};
                    const bubbleClass = isMine ? 'chat-bubble-me' : 'chat-bubble-other';
                    box.append(`
                        <div class="chat-bubble ${bubbleClass}">${m.message}</div>
                    `);
                });
                box.scrollTop(box[0].scrollHeight);
            })
            .fail(function(){ box.html('<div class="text-danger">Failed to load messages.</div>'); });
    }

    // Send message
    $('#teacher-chat-form').submit(function(e) {
        e.preventDefault();
        if (!currentUser) return alert('Select a student first.');

        const input = $(this).find('input[name=message]');
        const message = input.val().trim();
        if (!message) return;

        $.post("{{ url('/teacher/chat') }}/" + currentUser, { message })
            .done(function(data) {
                $('#teacher-chat-box').append(`
                    <div class="chat-bubble chat-bubble-me">${data.message}</div>
                `);
                $('#teacher-chat-box').scrollTop($('#teacher-chat-box')[0].scrollHeight);
                input.val('');
            })
            .fail(function() { alert('Unable to send.'); });
    });

    // Realtime Echo
    window.Echo.private('chat.{{ auth()->id() }}')
        .listen('MessageSent', (e) => {
            const senderId = e.sender_id;
            const msg = e.message;

            if (currentUser && currentUser == senderId) {
                $('#teacher-chat-box').append(`
                    <div class="chat-bubble chat-bubble-other">${msg}</div>
                `);
                $('#teacher-chat-box').scrollTop($('#teacher-chat-box')[0].scrollHeight);
            } else {
                let existing = document.querySelector(`.chat-user[data-user="${senderId}"]`);
                if (existing) {
                    let span = existing.querySelector(`.unread-${senderId}`);
                    if (span) {
                        let count = parseInt(span.innerText) || 0;
                        span.innerText = count + 1;
                        span.style.display = 'inline-block';
                    }
                } else {
                    $('#conversations-list').prepend(`
                        <li class="list-group-item d-flex justify-content-between align-items-center chat-user" data-user="${senderId}">
                            <span class="chat-user-name fw-bold">User</span>
                            <span class="badge bg-danger unread-${senderId}">1</span>
                        </li>
                    `);
                }
            }
        });
});
</script>
@endpush
