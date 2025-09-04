@extends('admin.layouts.app')
@section('title','Tefillin Records')
@section('content')

<div class="container">
  <h3>Tefillin Records</h3>
  <a class="btn btn-primary" href="{{ route('admin.tefillin-records.create') }}">➕ Add Tefillin Record</a>

  <div class="table-responsive">
    <table id="example" class="table table-striped w-100">
    <thead>
    <tr>
        <th>Ref</th>
        <th>User</th>
        <th>Parshe</th>
        <th>Phone Number</th>
        <th>From</th>
        <th>Paid</th>
        <th>Inspection Date</th>
        <th>Next Due Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        @foreach($records as $r)
        <tr>
        <td>{{ $r->reference_no }}</td>
        <td>{{ $r->user?->name ?? '-' }}</td>
        <td>{{ $r->parshe_number }}</td>
        <td>{{ $r->phone_number }}</td>
        <td>{{ $r->bought_from }}</td>
        <td>{{ $r->paid }}</td>
        <td>{{ $r->inspected_on->format('m-d-Y') }}</td>
        <td>{{ $r->next_due_date->format('m-d-Y') }}</td>
        <td>
            <a class="btn btn-sm btn-info" href="{{ route('admin.tefillin-records.show',$r) }}">Show</a>
            <a class="btn btn-sm btn-warning" href="{{ route('admin.tefillin-records.edit',$r) }}">Edit</a>
            <form class="d-inline" method="POST" action="{{ route('admin.tefillin-records.destroy',$r) }}">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Del</button>
            </form>
        </td>
        </tr>
        @endforeach
    </tbody>
    </table>
  </div>
</div>
@endsection
