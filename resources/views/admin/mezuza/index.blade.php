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
                    <td>{{ $record->inspected_by }}</td>
                    <td>{{ $record->inspected_on }}</td>
                    <td>{{ $record->next_due_date }}</td>
                    <td>{{ $record->paid ? '$'.$record->paid : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.mezuza-records.show',$record->id) }}" class="btn btn-info btn-sm">👁 View</a>
                        <a href="{{ route('admin.mezuza-records.edit',$record->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                        <form action="{{ route('admin.mezuza-records.destroy',$record->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $records->links() }}
</div>
@endsection

