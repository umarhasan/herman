@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>All Tests</h2>
    <a href="{{ route('admin.tests.create') }}" class="btn btn-primary mb-3">Create Test</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
        @foreach($tests as $test)
        <?php $i++; ?>
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $test->title }}</td>
                <td>{{ $test->class->name }}</td>
                <td>{{ $test->subject->name }}</td>
                <td>{{ $test->date }}</td>
                <td>
                    <a href="{{ route('admin.test.questions.edit', $test) }}" class="btn btn-success btn-sm">Questions</a>
                            <a href="{{ route('admin.tests.edit', $test->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
