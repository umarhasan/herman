@extends('teacher.layouts.app')

@section('title','Your Tests')

@section('content')
<div class="container py-4">
    <h2>Your Tests</h2>
    <a href="{{ route('teacher.tests.create') }}" class="btn btn-primary mb-3">Create New Test</a>

    <table class="table table-bordered table-striped" id="example">
        <thead>
            <tr>
                <th>#</th>
                <th>Teachers</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tests as $index => $test)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $test->teacher->name  ?? '-' }}</td>
                <td>{{ $test->title }}</td>
                <td>{{ $test->description }}</td>
                <td>
                    <a href="{{ route('teacher.tests.edit',$test) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('teacher.tests.destroy', $test) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete test?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

