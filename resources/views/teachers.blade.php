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
              {{-- <span class="availability-badge">
                Availability: {{ is_array($teacher->available_days) ? implode(', ', $teacher->available_days) : 'Not set' }}
              </span> --}}
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
    $(function(){

        let channel = null;

        function subscribeToChat(chatId){
            if(channel) {
                channel.unbind_all();
                channel.unsubscribe();
            }

            channel = pusher.subscribe("private-chat." + chatId);

            channel.bind("MessageSent", function(e){
                console.log("📩 Student got:", e);

                let mine = (e.sender_id == {{ auth()->id() }});
                let div = `<div class="${mine ? 'text-end mb-2':'text-start mb-2'}">
                    <span class="d-inline-block px-3 py-2 rounded ${mine ? 'bg-primary text-white':'bg-light'}">
                        <strong>${e.sender.name}:</strong> ${e.message}
                        <small class="d-block text-muted">${e.created_at}</small>
                    </span>
                </div>`;
                $("#chat-box-" + e.chat_id).append(div).scrollTop($("#chat-box-" + e.chat_id)[0].scrollHeight);
            });
        }

        // open modal and load messages
        $("[data-bs-target^='#teacherChat']").on("click", function(){
            let teacherId = $(this).data("bsTarget").replace("#teacherChat","");
            let chatBox = $("#chat-box-" + teacherId);
            chatBox.html("<div class='text-muted'>Loading...</div>");

            $.get(`/student/chat/messages/${teacherId}`, function(messages){
                chatBox.html("");
                let chatId = null;
                $.each(messages, function(i,msg){
                    if(!chatId && msg.chat_id) chatId = msg.chat_id;
                    chatBox.append(`<div class="${msg.sender_id == {{ auth()->id() }} ? 'text-end mb-2':'text-start mb-2'}">
                        <span class="d-inline-block px-3 py-2 rounded ${msg.sender_id == {{ auth()->id() }} ? 'bg-primary text-white':'bg-light'}">
                            <strong>${msg.sender.name}:</strong> ${msg.message}
                            <small class="d-block text-muted">${msg.created_at}</small>
                        </span>
                    </div>`);
                });
                if(chatId){
                    chatBox.attr("id","chat-box-"+chatId);
                    subscribeToChat(chatId);
                    $(`#teacherChat${teacherId} .chat-form`).data("chat",chatId);
                }

            });
        });

        // send message
        $(".chat-form").submit(function(e){
            e.preventDefault();
            let form = $(this);
            let teacherId = form.data("teacher");
            let msg = form.find("input[name='message']").val();

            $.post("{{ route('student.chat.send') }}",
                {_token:"{{ csrf_token() }}", teacher_id:teacherId, message:msg},
                function(d){
                    let chatBox = $("#chat-box-"+(d.chat_id ?? teacherId));
                    chatBox.append(`<div class="text-end mb-2">
                        <span class="d-inline-block px-3 py-2 rounded bg-primary text-white">
                            ${d.message}
                            <small class="d-block text-light">${d.created_at}</small>
                        </span>
                    </div>`);

                    form.find("input[name='message']").val("");
                    if(d.chat_id){
                        chatBox.attr("id","chat-box-"+d.chat_id);
                        subscribeToChat(d.chat_id);
                        form.data("chat",d.chat_id);
                    }
                },"json");
        });

    });
    </script>
@endpush
@endsection
