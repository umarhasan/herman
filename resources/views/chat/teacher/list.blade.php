@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Student List -->
    <div class="col-md-4">
        <h5>📚 My Students</h5>
        <ul class="list-group" id="student-list">
            @foreach($students as $studentId => $chats)
                @php $student = $chats->first()->student; @endphp
                <li class="list-group-item student-item" data-student="{{ $student->id }}">
                    {{ $student->name }}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Chat Box -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span id="chat-with">Select a student to start chat</span>
            </div>
            <div class="card-body" id="chat-box" style="height:300px; overflow-y:auto;">
                <p class="text-muted">No conversation selected.</p>
            </div>
            <div class="card-footer d-none" id="chat-form-box">
                <form id="chat-form">
                    @csrf
                    <input type="hidden" id="chat_student_id">
                    <div class="input-group">
                        <input type="text" id="chat_message" class="form-control" placeholder="Type message...">
                        <button class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (sabse pehle load karo) -->
@push('scripts')
<script>
    $(function(){

        let channel = null;
        let activeChatId = null;

        function subscribe(chatId){
            if(channel){
                channel.unbind_all();
                channel.unsubscribe();
            }
            channel = pusher.subscribe("private-chat." + chatId);
            activeChatId = chatId;

            channel.bind("MessageSent", function(e){
                console.log("📩 Teacher got:", e);
                let mine = (e.sender_id == {{ auth()->id() }});
                let div = `<div class="${mine ? 'text-end mb-2':'text-start mb-2'}">
                    <span class="d-inline-block px-3 py-2 rounded ${mine ? 'bg-primary text-white':'bg-light'}">
                        <strong>${e.sender.name}:</strong> ${e.message}
                        <small class="d-block text-muted">${e.created_at}</small>
                    </span>
                </div>`;
                $("#chat-box").append(div).scrollTop($("#chat-box")[0].scrollHeight);
            });
        }

        $(".student-item").on("click", function(){
            let studentId = $(this).data("student");
            $("#chat-with").text("Chat with "+$(this).text());
            $("#chat_student_id").val(studentId);
            $("#chat-form-box").removeClass("d-none");
            $("#chat-box").html("<p class='text-muted'>Loading chat...</p>");

            $.get(`/teacher/chat/messages/${studentId}`, function(messages){
                $("#chat-box").html("");
                if(messages.length == 0){
                    $("#chat-box").html("<p class='text-muted'>No messages yet.</p>");
                    return;
                }
                let chatId = messages[0].chat_id;
                $.each(messages, function(i,msg){
                    $("#chat-box").append(`<div class="${msg.sender_id == {{ auth()->id() }} ? 'text-end mb-2':'text-start mb-2'}">
                        <span class="d-inline-block px-3 py-2 rounded ${msg.sender_id == {{ auth()->id() }} ? 'bg-primary text-white':'bg-light'}">
                            <strong>${msg.sender.name}:</strong> ${msg.message}
                            <small class="d-block text-muted">${msg.created_at}</small>
                        </span>
                    </div>`);
                });
                $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                subscribe(chatId);
                $("#chat-form").data("chat",chatId);
            });
        });

        $("#chat-form").submit(function(e){
            e.preventDefault();
            let studentId = $("#chat_student_id").val();
            let msg = $("#chat_message").val();

            $.post("{{ route('teacher.chat.send') }}",
                {_token:"{{ csrf_token() }}", student_id:studentId, message:msg},
                function(d){
                    $("#chat-box").append(`<div class="text-end mb-2">
                        <span class="d-inline-block px-3 py-2 rounded bg-primary text-white">
                            ${d.message}
                            <small class="d-block text-light">${d.created_at}</small>
                        </span>
                    </div>`);
                    $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                    $("#chat_message").val("");
                    if(d.chat_id){
                        subscribe(d.chat_id);
                        $("#chat-form").data("chat",d.chat_id);
                    }
                },"json");
        });

    });
    </script>
@endpush
@endsection
