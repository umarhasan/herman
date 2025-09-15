<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{ $test->title }}</title>
    <style>
        @page { margin: 30px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }
        h1, h2, h3 {
            margin: 0 0 5px 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #555;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .test-meta {
            margin-bottom: 15px;
        }
        .question {
            margin-bottom: 25px;
            padding: 10px;
            /* border: 1px solid #ddd; */
            border-radius: 6px;
            background: #f9f9f9;
        }
        .q-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .media {
            margin: 5px 0;
        }
        .media img {
            max-width: 200px;
            display: block;
        }
        .options {
            margin-top: 8px;
        }
        .options li {
            margin-bottom: 4px;
        }
        .teacher {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $test->title }}</h1>
        <div class="teacher">Teacher: {{ $test->teacher->name ?? 'N/A' }}</div>
    </div>

    <div class="test-meta">
        <p><strong>Description:</strong> {{ $test->description }}</p>
    </div>

    @foreach($test->questions as $idx => $q)
        <div class="question">
            <div class="q-title">
                Q{{ $idx+1 }}: {!! nl2br(e($q->question_text)) !!}
            </div>

            {{-- Media inside question --}}
            @if($q->image_path)
                <div class="media">
                    <img src="{{ public_path('storage/'.$q->image_path) }}">
                </div>
            @endif
            @if($q->audio_path)
                <div class="media">Audio: {{ asset('storage/'.$q->audio_path) }}</div>
            @endif
            @if($q->video_path)
                <div class="media">Video: {{ asset('storage/'.$q->video_path) }}</div>
            @endif

            {{-- Options --}}
            <ol type="A" class="options">
                @foreach($q->options as $opt)
                    <li>
                        {!! e($opt->option_text) !!}
                        @if($opt->image_path)
                            <div class="media"><img src="{{ public_path('storage/'.$opt->image_path) }}"></div>
                        @endif
                        @if($opt->audio_path)
                            <div class="media">Audio: {{ asset('storage/'.$opt->audio_path) }}</div>
                        @endif
                        @if($opt->video_path)
                            <div class="media">Video: {{ asset('storage/'.$opt->video_path) }}</div>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    @endforeach
</body>
</html>
