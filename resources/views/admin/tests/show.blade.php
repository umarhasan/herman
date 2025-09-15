@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h2>{{ $test->title }}</h2>
    <a href="{{ route('admin.tests.download', $test) }}" class="btn btn-success mb-2">Download PDF</a>

    @foreach($test->questions as $idx => $q)
        <div class="card mb-2 p-2">
            <p><strong>Q{{ $idx+1 }}:</strong> {!! nl2br(e($q->question_text)) !!}</p>
            @if($q->image_path) <img src="{{ asset('storage/'.$q->image_path) }}" style="max-width:200px"> @endif
            @if($q->audio_path)
                <audio controls><source src="{{ asset('storage/'.$q->audio_path) }}"></audio>
            @endif
            @if($q->video_path)
                <video width="320" controls><source src="{{ asset('storage/'.$q->video_path) }}"></video>
            @endif
            <ul>
            @foreach($q->options as $opt)
                <li>
                    {!! e($opt->option_text) !!}
                    @if($opt->image_path) <br><img src="{{ asset('storage/'.$opt->image_path) }}" style="max-width:120px"> @endif
                    @if($opt->audio_path) <br><audio controls><source src="{{ asset('storage/'.$opt->audio_path) }}"></audio> @endif
                    @if($opt->video_path) <br><video width="240" controls><source src="{{ asset('storage/'.$opt->video_path) }}"></video> @endif
                </li>
            @endforeach
            </ul>
        </div>
    @endforeach
</div>
@endsection
