@extends('admin.layouts.app')


@section('content')
<div class="container">
        <h2>Joke Details</h2>
        <div>
            <strong>Joke Name:</strong> {{ $joke->joke_name }}
        </div>
        <div>
            <strong>Joke Detail:</strong> {{ $joke->joke_detail }}
        </div>
        <a href="{{ route('admin.files.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection
