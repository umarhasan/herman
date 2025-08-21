@extends('admin.layouts.app')
@section('content')
<div class="container">
  <h2>Edit Inspection</h2>
  <form action="{{ route('admin.tefillin_inspections.update',$inspection) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('_partials.tefillin_inspections.form_fields')
    <button class="btn btn-success">Update</button>
  </form>
</div>
@endsection
