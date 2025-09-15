@extends('teacher.layouts.app')
@section('content')
<div class="container">
    <h2>Edit Test: {{ $test->title }}</h2>

    <hr>
    <h4>Add Question</h4>
    <form action="{{ route('teacher.tests.questions.store', $test) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Question Text</label>
            <textarea name="question_text" class="form-control" required></textarea>
        </div>

        {{-- <div class="form-row">
            <div class="col">
                <label>Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            <div class="col">
                <label>Audio (optional)</label>
                <input type="file" name="audio" accept="audio/*" class="form-control">
            </div>
            <div class="col">
                <label>Video (optional)</label>
                <input type="file" name="video" accept="video/*" class="form-control">
            </div>
        </div> --}}

        <hr>
        <h5>Options (2-6)</h5>
        <div id="options-area">
            @for($i=0;$i<4;$i++)
            <div class="option-row border p-2 mb-2">
                <label>Option {{ $i+1 }}</label>
                <input type="text" name="options[{{ $i }}][text]" class="form-control mb-1" placeholder="Text (optional)">
                <div class="form-row">
                    {{-- <div class="col">
                        <input type="file" name="options[{{ $i }}][image]" accept="image/*" class="form-control">
                    </div>
                    <div class="col">
                        <input type="file" name="options[{{ $i }}][audio]" accept="audio/*" class="form-control">
                    </div>
                    <div class="col">
                        <input type="file" name="options[{{ $i }}][video]" accept="video/*" class="form-control">
                    </div> --}}
                </div>
                <label class="mt-2"><input type="checkbox" name="correct[]" value="{{ $i }}"> Correct</label>
            </div>
            @endfor
        </div>

        <button type="button" id="add-option" class="btn btn-sm btn-outline-secondary">Add Option</button>
        <button type="button" id="remove-option" class="btn btn-sm btn-outline-danger">Remove Option</button>

        <div class="mt-3">
            <button class="btn btn-success">Add Question</button>
        </div>
    </form>

    <hr>
    <h4>Existing Questions</h4>
    @foreach($test->questions as $question)
        <div class="card mb-2">
            <div class="card-body">
                <p><strong>Q:</strong> {!! nl2br(e($question->question_text)) !!}</p>
                @if($question->image_path) <img src="{{ asset('storage/'.$question->image_path) }}" style="max-width:200px"> @endif
                @if($question->audio_path)
                    <audio controls>
                        <source src="{{ asset('storage/'.$question->audio_path) }}">
                    </audio>
                @endif
                @if($question->video_path)
                    <video width="320" controls>
                        <source src="{{ asset('storage/'.$question->video_path) }}">
                    </video>
                @endif

                <ul>
                    @foreach($question->options as $opt)
                        <li>
                            {!! e($opt->option_text) !!}
                            {{-- @if($opt->image_path) <br><img src="{{ asset('storage/'.$opt->image_path) }}" style="max-width:120px"> @endif
                            @if($opt->audio_path)
                                <br><audio controls><source src="{{ asset('storage/'.$opt->audio_path) }}"></audio>
                            @endif
                            @if($opt->video_path)
                                <br><video width="240" controls><source src="{{ asset('storage/'.$opt->video_path) }}"></video>
                            @endif --}}
                            @if($opt->is_correct) <strong> ✅ Correct</strong> @endif
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('teacher.questions.destroy', $question) }}" onsubmit="return confirm('Delete question?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete Question</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    let area = document.getElementById('options-area');
    document.getElementById('add-option').addEventListener('click', function(){
        const count = area.querySelectorAll('.option-row').length;
        if(count >= 6) return alert('Max 6 options');
        const idx = count;
        const div = document.createElement('div');
        div.className = 'option-row border p-2 mb-2';
        div.innerHTML = `
            <label>Option ${idx+1}</label>
            <input type="text" name="options[${idx}][text]" class="form-control mb-1" placeholder="Text (optional)">
            <!--<div class="form-row">
                <div class="col"><input type="file" name="options[${idx}][image]" accept="image/*" class="form-control"></div>
                <div class="col"><input type="file" name="options[${idx}][audio]" accept="audio/*" class="form-control"></div>
                <div class="col"><input type="file" name="options[${idx}][video]" accept="video/*" class="form-control"></div>
            </div>-->
            <label class="mt-2"><input type="checkbox" name="correct[]" value="${idx}"> Correct</label>
        `;
        area.appendChild(div);
    });

    document.getElementById('remove-option').addEventListener('click', function(){
        const rows = area.querySelectorAll('.option-row');
        if(rows.length <= 2) return alert('Minimum 2 options required');
        rows[rows.length-1].remove();
    });
});
</script>
@endsection
