@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>📜 Mezuza Records</h2>
    <a href="{{ route('admin.mezuza-records.create') }}" class="btn btn-primary mb-3">➕ Add Mezuza</a>

    <table id="example" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Location</th>
                <th>Door</th>                {{-- new --}}
                <th>Phone</th>   {{-- new --}}
                <th>Inspected By</th>
                <th>Inspected On</th>
                <th>Next Due Date</th>
                <th>Paid</th>
                <th>🔧 Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->user?->name }}</td>
                    <td>{{ $record->location }}</td>
                    <td>{{ $record->door_description ?? '-' }}</td>  {{-- new --}}
                    <td>{{ $record->bought_from_phone ?? '-' }}</td> {{-- new --}}
                    <td>{{ $record->inspected_by }}</td>
                     {{-- ✅ format Y-m-d if not null --}}
        <td>
            {{ $record->inspected_on ? $record->inspected_on->format('Y-m-d') : '-' }}
        </td>
        <td>
            {{ $record->next_due_date ? \Carbon\Carbon::parse($record->next_due_date)->format('Y-m-d') : '-' }}
        </td>
                    <td>{{ $record->paid ? '$'.$record->paid : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.mezuza-records.show',$record->id) }}" class="btn btn-info btn-sm">👁 </a>
                        <a href="{{ route('admin.mezuza-records.edit',$record->id) }}" class="btn btn-warning btn-sm">✏</a>
                        <form action="{{ route('admin.mezuza-records.destroy',$record->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">🗑</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $records->links() }}
</div>
@endsection

