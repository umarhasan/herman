@extends('user.layouts.app')
@section('content')
<div class="container">
  <h2>New Inspection</h2>
  <form method="POST" action="{{ route('user.tefillin_inspections.store') }}">
    @include('_partials.tefillin_inspections.form_fields', ['parts'=>['A','B','C','D'],'sides'=>['left','right','head']])
  </form>
</div>
@endsection
