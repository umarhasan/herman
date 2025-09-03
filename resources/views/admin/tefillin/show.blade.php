@extends('admin.layouts.app')
@section('title','Tefillin Record')
@section('content')
<div class="card p-3">
  <h5>Parshe #{{ $tefillin_record->parshe_number }} — {{ $tefillin_record->reference_no }}</h5>
  <div class="row">
    <div class="col-md-4"><strong>Written On:</strong> {{ $tefillin_record->written_on }}</div>
    <div class="col-md-4"><strong>Bought On:</strong> {{ $tefillin_record->bought_on }}</div>
    <div class="col-md-4"><strong>Bought From:</strong> {{ $tefillin_record->bought_from }}</div>
  </div>
  <div class="row mt-2">
    <div class="col-md-4"><strong>Paid:</strong> {{ $tefillin_record->paid }}</div>
    <div class="col-md-4"><strong>Inspected By:</strong> {{ $tefillin_record->inspected_by }}</div>
    <div class="col-md-4"><strong>Next Due:</strong> {{ $tefillin_record->next_due_date }}</div>
  </div>
  <div class="mt-3">
    <a class="btn btn-warning" href="{{ route('admin.tefillin-records.edit',$tefillin_record) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('admin.tefillin-records.index') }}">Back</a>
  </div>
</div>
@endsection
