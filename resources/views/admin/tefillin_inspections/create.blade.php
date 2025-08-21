
@extends('admin.layouts.app')
@section('content')
<div class="container">
  <h2>New Inspection</h2>
  <form action="{{ route('admin.tefillin_inspections.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('_partials.tefillin_inspections.form_fields')
    <button class="btn btn-success">Save</button>
  </form>
</div>
@endsection
