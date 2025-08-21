@extends('teacher.layouts.app')
@section('content')
<div class="container">
  <h2>Edit Inspection</h2>
  <form method="POST" action="{{ route('teacher.tefillin_inspections.update', $inspection) }}">
    @method('PUT')
    @include('_partials.tefillin_inspections.form_fields', ['inspection'=>$inspection,'parts'=>['A','B','C','D'],'sides'=>['left','right','head']])
  </form>
</div>
@endsection
