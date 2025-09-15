@extends('student.layouts.app')
@section('content')
<div class="container">
    <h2>Available Tests</h2>
    @foreach($tests as $test)
        <div class="card mb-2">
            <div class="card-body">
                <h4>{{ $test->title }}</h4>
                <p>{{ $test->description }}</p>
                <a href="{{ route('student.tests.show', $test) }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ route('student.tests.download', $test) }}" class="btn btn-sm btn-success">Download PDF</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
