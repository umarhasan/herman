@extends('admin.layouts.app')

@section('title', 'Edit Questions for Test')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <h3>Edit Questions for Test: {{ $test->name }}</h3>
    </div>

    <div class="content">
        <form method="POST" action="{{ route('admin.test.questions.update', [$test->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @foreach($test->questions as $index => $question)
                @php
                    // Determine input mode dynamically from DB
                    $inputMode = $question->question_text ? 'text' : ($question->question_audio ? 'audio' : ($question->question_video ? 'video' : 'text'));
                @endphp

                <hr>
                <h5>Question #{{ $index + 1 }}</h5>
                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">

                <div class="form-group">
                    <label>Question Input Mode</label>
                    <select name="questions[{{ $index }}][input_mode]" class="form-control input-mode" data-index="{{ $index }}">
                        <option value="text" {{ $inputMode === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="audio" {{ $inputMode === 'audio' ? 'selected' : '' }}>Audio</option>
                        <option value="video" {{ $inputMode === 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>

                {{-- Question Text --}}
                <div class="form-group question-text-{{ $index }} input-block" style="display: none;">
                    <label>Question Text</label>
                    <input type="text" name="questions[{{ $index }}][question_text]" class="form-control" value="{{ $question->question_text }}">
                </div>

                {{-- Question Audio --}}
                <div class="form-group question-audio-{{ $index }} input-block" style="display: none;">
                    <label>Question Audio</label>
                    <input type="file" name="questions[{{ $index }}][question_audio]" class="form-control" accept="audio/*">
                    @if($question->question_audio)
                        <audio controls src="{{ asset('storage/' . $question->question_audio) }}"></audio>
                    @endif
                </div>

                {{-- Question Video --}}
                <div class="form-group question-video-{{ $index }} input-block" style="display: none;">
                    <label>Question Video</label>
                    <input type="file" name="questions[{{ $index }}][question_video]" class="form-control" accept="video/*">
                    @if($question->question_video)
                        <video controls width="300" src="{{ asset('storage/' . $question->question_video) }}"></video>
                    @endif
                </div>

                {{-- Options --}}
                @foreach(['a', 'b', 'c', 'd'] as $opt)
                    <hr>
                    <h6>Option {{ strtoupper($opt) }}</h6>

                    <div class="form-group">
                        <label>Text</label>
                        <input type="text" name="questions[{{ $index }}][option_{{ $opt }}]" class="form-control" value="{{ $question->{'option_'.$opt} }}">
                    </div>

                    <div class="form-group">
                        <label>Audio</label>
                        <input type="file" name="questions[{{ $index }}][option_{{ $opt }}_audio]" class="form-control" accept="audio/*">
                        @if($question->{'option_'.$opt.'_audio'})
                            <audio controls src="{{ asset('storage/' . $question->{'option_'.$opt.'_audio'}) }}"></audio>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Video</label>
                        <input type="file" name="questions[{{ $index }}][option_{{ $opt }}_video]" class="form-control" accept="video/*">
                        @if($question->{'option_'.$opt.'_video'})
                            <video controls width="300" src="{{ asset('storage/' . $question->{'option_'.$opt.'_video'}) }}"></video>
                        @endif
                    </div>
                @endforeach

                {{-- Correct Answer --}}
                <div class="form-group">
                    <label>Correct Answer</label>
                    <select name="questions[{{ $index }}][correct_answer]" class="form-control">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                            <option value="{{ $opt }}" {{ $question->correct_answer == $opt ? 'selected' : '' }}>
                                Option {{ strtoupper($opt) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-success">Update All Questions</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.input-mode').forEach(function (select) {
        toggleInputs(select);

        select.addEventListener('change', function () {
            toggleInputs(this);
        });
    });

    function toggleInputs(selectElement) {
        var index = selectElement.dataset.index;
        var mode = selectElement.value;

        document.querySelector('.question-text-' + index).style.display = (mode === 'text') ? 'block' : 'none';
        document.querySelector('.question-audio-' + index).style.display = (mode === 'audio') ? 'block' : 'none';
        document.querySelector('.question-video-' + index).style.display = (mode === 'video') ? 'block' : 'none';
    }
});
</script>
@endsection
