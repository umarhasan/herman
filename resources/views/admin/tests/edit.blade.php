@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Test</h2>
    <form action="{{ route('admin.tests.update', $test->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ $test->title }}" required>
        </div>
        <div class="form-group">
            <label>Class</label>
            <select name="school_class_id" class="form-control">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $test->school_class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" class="form-control">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $test->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input name="date" type="date" value="{{ $test->date }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
