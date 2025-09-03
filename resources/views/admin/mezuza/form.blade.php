@extends('admin.layouts.app')


@section('content')
<div class="container">
    <h2>{{ $record->exists ? '✏ Edit Mezuza Record' : '➕ Add Mezuza Record' }}</h2>

    <form action="{{ $record->exists ? route('admin.mezuza-records.update',$record->id) : route('admin.mezuza-records.store') }}" method="POST">
        @csrf
        @if($record->exists) @method('PUT') @endif

        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control">
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($record->user_id==$user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location',$record->location) }}" required>
        </div>

        <div class="form-group">
            <label>Written On</label>
            <input type="date" name="written_on" class="form-control" value="{{ old('written_on',$record->written_on) }}">
        </div>

        <div class="form-group">
            <label>Bought From</label>
            <input type="text" name="bought_from" class="form-control" value="{{ old('bought_from',$record->bought_from) }}">
        </div>

        <div class="form-group">
            <label>Paid</label>
            <input type="number" step="0.01" name="paid" class="form-control" value="{{ old('paid',$record->paid) }}">
        </div>

        <div class="form-group">
            <label>Inspected By</label>
            <input type="text" name="inspected_by" class="form-control" value="{{ old('inspected_by',$record->inspected_by) }}">
        </div>

        <div class="form-group">
            <label>Inspected On</label>
            <input type="date" name="inspected_on" class="form-control" value="{{ old('inspected_on',$record->inspected_on) }}">
        </div>


        <div class="form-group">
            <label>Reminder Email On</label>
            <input type="date" name="reminder_email_on" class="form-control" value="{{ old('reminder_email_on',$record->reminder_email_on) }}">
        </div>

        <button class="btn btn-success mt-2">💾 Save</button>
        <a href="{{ route('admin.mezuza-records.index') }}" class="btn btn-secondary mt-2">⬅ Back</a>
    </form>
</div>
@endsection

