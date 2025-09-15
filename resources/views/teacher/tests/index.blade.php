@extends('teacher.layouts.app')
@section('content')
<div class="container">
    <h2>Your Tests</h2>
    <a href="{{ route('teacher.tests.create') }}" class="btn btn-primary">Create New Test</a>
    <hr>
    @foreach($tests as $test)
        <div class="card mb-2">
            <div class="card-body">
                <h4>{{ $test->title }}</h4>
                <p>{{ $test->description }}</p>
                <a href="{{ route('teacher.tests.edit',$test) }}" class="btn btn-sm btn-secondary">Edit</a>

                <form action="{{ route('teacher.tests.destroy', $test) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete test?')">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection