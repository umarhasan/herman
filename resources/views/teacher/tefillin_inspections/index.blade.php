@extends('teacher.layouts.app')

@section('content')
<div class="container">
    <h3>Teacher - Tefillin Inspections</h3>
    <a href="{{ route('teacher.tefillin_inspections.create') }}" class="btn btn-primary mb-2">Add Inspection</a>
    <table id="example" class="table table-striped w-100">
        <thead>
            <tr>
                <th>User</th>
                <th>Side</th>
                <th>Part</th>
                <th>Date of Buy</th>
                <th>Next Inspection</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($inspections as $insp)
            <tr>
                <td>{{ $insp->user->name }}</td>
                <td>{{ ucfirst($insp->side) }}</td>
                <td>{{ $insp->part_name }}</td>
                <td>{{ $insp->date_of_buy }}</td>
                <td>{{ $insp->next_inspection_date }}</td>
                <td>{{ $insp->status }}</td>
                <td><a href="{{ route('teacher.tefillin_inspections.edit',$insp) }}" class="btn btn-warning btn-sm">Edit</a></td>
                {{-- <td>
                    <a href="{{ route('teacher.tefillin_inspections.edit',$insp->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('teacher.tefillin_inspections.destroy',$insp->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
