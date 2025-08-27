@extends('layouts.app')

@section('title', 'Teacher Chats')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">💬 My Chats</h3>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                @foreach($conversations as $userId => $messages)
                    @php
                        // get the other user
                        $first = $messages->first();
                        $other = ($first->sender_id == auth()->id()) ? $first->receiver : $first->sender;
                    @endphp
                    <li class="list-group-item chat-user" data-user="{{ $other->id }}">{{ $other->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-8">
            <div id="teacher-chat-box" class="border rounded p-3 mb-3 bg-white" style="height:400px;overflow-y:auto;">
                <div class="text-muted">Select a student to start chatting</div>
            </div>

            <form id="teacher-chat-form" style="display:none;">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let currentUser = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // click a student
    $(document).on('click', '.chat-user', function() {
        $('.chat-user').removeClass('active');
        $(this).addClass('active');

        currentUser = $(this).data('user');
        $('#teacher-chat-form').show();
        loadMessages(currentUser);
    });

    function loadMessages(userId) {
        const box = $('#teacher-chat-box');
        box.html('<div class="text-muted">Loading...</div>');

        $.get("{{ url('/teacher/chat') }}/" + userId)
            .done(function(data) {
                box.html('');
                data.forEach(m => {
                    const who = (m.sender_id == {{ auth()->id() }}) ? 'You' : m.sender.name;
                    const align = (m.sender_id == {{ auth()->id() }}) ? 'text-end' : 'text-start';
                    box.append(`<div class="${align} mb-2"><small><strong>${who}:</strong></small><div>${m.message}</div></div>`);
                });
                box.scrollTop(box[0].scrollHeight);
            })
            .fail(function() { box.html('<div class="text-danger">Failed to load messages.</div>'); });
    }

    $('#teacher-chat-form').submit(function(e) {
        e.preventDefault();
        if (!currentUser) return alert('Select a student first.');

        const input = $(this).find('input[name=message]');
        const message = input.val().trim();
        if (!message) return;

        $.post("{{ url('/teacher/chat') }}/" + currentUser, { message })
            .done(function(data) {
                $('#teacher-chat-box').append(`<div class="text-end mb-2"><small><strong>You:</strong></small><div>${data.message}</div></div>`);
                $('#teacher-chat-box').scrollTop($('#teacher-chat-box')[0].scrollHeight);
                input.val('');
            })
            .fail(function() { alert('Unable to send.'); });
    });

    // Listen incoming messages to teacher
    window.Echo.private('chat.{{ auth()->id() }}')
        .listen('MessageSent', (e) => {
            const payload = e;
            // if currently chatting with sender, append, else you can show a notification
            if (currentUser && currentUser == payload.sender_id) {
                $('#teacher-chat-box').append(`<div class="text-start mb-2"><small><strong>${payload.sender.name}:</strong></small><div>${payload.message}</div></div>`);
                $('#teacher-chat-box').scrollTop($('#teacher-chat-box')[0].scrollHeight);
            } else {
                // optional visual notification
                console.log('New message from', payload.sender.name);
            }
        });
});
</script>
@endpush
