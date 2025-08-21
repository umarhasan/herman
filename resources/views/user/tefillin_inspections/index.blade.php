@extends('user.layouts.app')
@section('content')
<div class="container">
  <h2>My Tefillin Inspections</h2>
  <a href="{{ route('user.tefillin_inspections.create') }}" class="btn btn-success mb-3">New</a>
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

  <table id="example" class="table table-striped w-100">
    <thead>
    <tr>
        <th>#</th>
        <th>Side</th>
        <th>Part</th>
        <th>Date of Buy</th>
        <th>Next</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
      @foreach($inspections as $ins)
      <tr>
        <td>{{ $ins->id }}</td>
        <td>{{ ucfirst($ins->side) }}</td>
        <td>Part {{ $ins->part_name }}</td>
        <td>{{ optional($ins->date_of_buy)->format('Y-m-d') }}</td>
        <td>{{ optional($ins->next_inspection_date)->format('Y-m-d') }}</td>
        <td>{{ $ins->status }}</td>
        <td>
            <a href="{{ route('user.tefillin_inspections.edit',$ins) }}" class="btn btn-warning btn-sm">Edit</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $inspections->links() }}
</div>
@endsection
