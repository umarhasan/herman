@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>👁 Mezuza Record Detail</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>User:</strong> {{ $record->user?->name }}</p>
            <p><strong>Location:</strong> {{ $record->location }}</p>
            <p><strong>Written On:</strong> {{ $record->written_on }}</p>
            <p><strong>Bought From:</strong> {{ $record->bought_from }}</p>
            <p><strong>Paid:</strong> {{ $record->paid ? '$'.$record->paid : '-' }}</p>
            <p><strong>Inspected By:</strong> {{ $record->inspected_by }}</p>
            <p><strong>Inspected On:</strong> {{ $record->inspected_on }}</p>
            <p><strong>Next Due Date:</strong> {{ $record->next_due_date }}</p>
            <p><strong>Reminder Email On:</strong> {{ $record->reminder_email_on }}</p>
        </div>
    </div>
    <a href="{{ route('admin.mezuza-records.index') }}" class="btn btn-secondary mt-3">⬅ Back</a>
</div>
@endsection

