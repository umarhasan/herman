@extends('admin.layouts.app')
@section('content')
<div class="container">
  <h2>Tefillin Inspections</h2>
  <a href="{{ route('admin.tefillin_inspections.create') }}" class="btn btn-success mb-3">New</a>
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th><th>User</th><th>Side</th><th>Part</th>
        <th>Date of Buy</th><th>Next Inspection</th><th>Status</th><th>Image</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach($inspections as $ins)
      <tr>
        <td>{{ $ins->id }}</td>
        <td>{{ $ins->user->name }}</td>
        <td>{{ ucfirst($ins->side) }}</td>
        <td>{{ $ins->part_name ? "Part ".$ins->part_name : 'Full Box' }}</td>
        <td>{{ optional($ins->date_of_buy)->format('Y-m-d') }}</td>
        <td>{{ optional($ins->next_inspection_date)->format('Y-m-d') }}</td>
        <td>
            <span class="badge bg-{{ $ins->status==='active'?'success':'danger' }}">
                {{ ucfirst($ins->status) }}
            </span>
        </td>
        <td>
          @if($ins->image)
            <img src="{{ asset('storage/'.$ins->image) }}" width="50">
          @endif
        </td>
        <td class="d-flex gap-2">
          <a href="{{ route('admin.tefillin_inspections.edit',$ins) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('admin.tefillin_inspections.destroy',$ins) }}" method="POST" onsubmit="return confirm('Remove?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Remove</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $inspections->links() }}
</div>
@endsection
