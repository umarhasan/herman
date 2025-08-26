@extends('admin.layouts.app')

@section('title','Edit Inspection')

@section('content')
<div class="container">
    <h2 class="mb-3">Edit Inspection</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.inspections.update',$inspection) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Reference No</label>
            <input type="text" name="reference_no" value="{{ old('reference_no', $inspection->reference_no) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>User (Optional)</label>
            <select name="user_id" class="form-control">
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $inspection->user_id)==$user->id?'selected':'' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ old('type', $inspection->type)==$type?'selected':'' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Date of Inspection</label>
            <input type="date" name="date_of_inspection" value="{{ old('date_of_inspection', $inspection->date_of_inspection?->format('Y-m-d')) }}" class="form-control" required>
            <small class="text-muted">Next inspection date will be auto-calculated if empty.</small>
        </div>

        <div class="mb-3">
            <label>Inspector Name</label>
            <input type="text" name="inspector_name" value="{{ old('inspector_name', $inspection->inspector_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ old('status', $inspection->status)==$st?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes', $inspection->notes) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Attachment</label>
            @if($inspection->attachment)
                <p>Current: <a href="{{ asset('storage/'.$inspection->attachment) }}" target="_blank">View</a></p>
            @endif
            <input type="file" name="attachment" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.inspections.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
