@extends('teacher.layouts.app')
@section('content')
<div class="container">
    <h2>Create Test</h2>
    <form action="{{ route('teacher.tests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
