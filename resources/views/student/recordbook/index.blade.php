@extends('student.layouts.app')
@section('title','Record Book Dashboard')
@section('content')
<h3>Users</h3>
<div class="table-responsive">
<table id="example" class="table table-striped w-100">
  <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
  <tbody>
    @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td>{{ $u->name }}</td>
      <td>{{ $u->email }}</td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('student.recordbook.show',$u) }}">View Record Book</a>
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('student.recordbook.pdf',$u) }}">Download PDF</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection
