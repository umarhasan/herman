@extends('admin.layouts.app')

@section('title','Available Tests')

@section('content')
<div class="container py-4">
    <h2>Available Tests</h2>

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
                <td>{{ $test->teacher->name ?? '-'  }}</td>
                <td>{{ $test->title }}</td>
                <td>{{ $test->description }}</td>
                <td>
                    <a href="{{ route('admin.tests.show', $test) }}" class="btn btn-sm btn-primary">View</a>
                    <a href="{{ route('admin.tests.download', $test) }}" class="btn btn-sm btn-success">Download PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

