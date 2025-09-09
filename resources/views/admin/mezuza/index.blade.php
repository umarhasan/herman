@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h2>Mezuza Records</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.mezuza-records.create') }}" class="btn btn-primary mb-3">➕ Add New</a>

    <table id="example" class="table table-striped w-100">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Address</th>
                {{-- <th>Door</th>
                <th>Seller</th> --}}
                <th>Phone</th>
                <th>Paid</th>
                <th>Inspected On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->reference_no }}</td>
                <td>{{ $record->user?->name }}</td>
                <td>
                    <ul class="list-unstyled mb-0">
                      <li>{{ $record->house_number }} {{ $record->street_number }}</li>
                      <li>{{ $record->street_name }}</li>
                      <li>{{ $record->area_name }}</li>
                      <li>{{ $record->city }}</li>
                      <li>{{ $record->country }}</li>
                    </ul>
                  </td>
                {{-- <td>{{ $record->door_description }}</td> --}}
                {{-- <td>{{ $record->bought_from }}</td> --}}
                <td>{{ $record->bought_from_phone_code }} {{ $record->bought_from_phone_number }}</td>
                <td>{{ $record->paid }}</td>
                <td>{{ optional($record->inspected_on)->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.mezuza-records.edit',$record->id) }}" class="btn btn-sm btn-warning">✏ Edit</a>
                    <form action="{{ route('admin.mezuza-records.destroy',$record->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">🗑 Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $records->links() }}
</div>
@endsection
