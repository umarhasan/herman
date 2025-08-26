@extends('admin.layouts.app')

@section('title','Inspections')

@section('content')
<div class="container">
    <h2 class="mb-3">Inspection Records</h2>
    <a href="{{ route('admin.inspections.create') }}" class="btn btn-primary mb-3">+ Add Inspection</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="example" class="table table-striped" style="width: 100%">
        <thead>
            <tr>
                <th>Ref No</th>
                <th>Type</th>
                <th>Date of Inspection</th>
                <th>Next Inspection</th>
                <th>Inspector</th>
                <th>Status</th>
                <th>Attachment</th>
                <th>User</th>
                <th style="width:140px">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($inspections as $inspection)
            <tr>
                <td>{{ $inspection->reference_no }}</td>
                <td>{{ ucfirst($inspection->type) }}</td>
                <td>{{ $inspection->date_of_inspection?->format('d-m-Y') }}</td>
                <td>{{ $inspection->next_inspection_date?->format('d-m-Y') }}</td>
                <td>{{ $inspection->inspector_name }}</td>
                <td>{{ ucfirst(str_replace('_',' ',$inspection->status)) }}</td>
                <td>
                    @if($inspection->attachment)
                        <a href="{{ asset('storage/'.$inspection->attachment) }}" target="_blank">View</a>
                    @endif
                </td>
                <td>{{ $inspection->user?->name }}</td>
                <td>
                    <a href="{{ route('admin.inspections.edit',$inspection) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.inspections.destroy',$inspection) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this record?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="9" class="text-center">No records found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $inspections->links() }}
    </div>
</div>
@endsection
