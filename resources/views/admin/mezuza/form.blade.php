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

        {{-- Address of House Location --}}
        <div class="form-group">
            <label>Address of House Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location',$record->location) }}" required>
        </div>

        {{-- Which Door the Mezuzah is Mounted --}}
        <div class="form-group">
            <label>Which Door / Door Number</label>
            <input type="text" name="door_description" class="form-control" value="{{ old('door_description',$record->door_description) }}" placeholder="E.g. Main Entrance, Room #2, etc.">
        </div>

        <div class="form-group">
            <label>Written On</label>
            <input type="date" name="written_on" class="form-control"
                value="{{ old('written_on', isset($record->written_on) ? \Carbon\Carbon::parse($record->written_on)->format('Y-m-d') : '') }}">
        </div>

        {{-- Bought From --}}
        <div class="form-group">
            <label>Bought From (Store / Seller Name)</label>
            <input type="text" name="bought_from" class="form-control" value="{{ old('bought_from',$record->bought_from) }}">
        </div>

        {{-- Seller Phone with Area Code --}}
        <div class="form-group">
            <label>Seller Phone (with Area Code)</label>
            <input type="tel"
                   name="bought_from_phone"
                   class="form-control"
                   value="{{ old('bought_from_phone',$record->bought_from_phone) }}"
                   pattern="^\+?[0-9]{7,15}$"
                   title="Enter a valid phone number with area code. Example: +14155552671 or +923001234567">
            <small class="text-muted">Format: +CountryCode then number, 7–15 digits</small>
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
            <input type="date" name="inspected_on" class="form-control"
                value="{{ old('inspected_on', isset($record->inspected_on) ? \Carbon\Carbon::parse($record->inspected_on)->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label>Reminder Email On</label>
            <input type="date" name="reminder_email_on" class="form-control"
                value="{{ old('reminder_email_on', isset($record->reminder_email_on) ? \Carbon\Carbon::parse($record->reminder_email_on)->format('Y-m-d') : '') }}">
        </div>

        <button class="btn btn-success mt-2">💾 Save</button>
        <a href="{{ route('admin.mezuza-records.index') }}" class="btn btn-secondary mt-2">⬅ Back</a>
    </form>
</div>
@endsection
