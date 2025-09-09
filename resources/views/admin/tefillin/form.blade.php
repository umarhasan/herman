@extends('admin.layouts.app')
@section('title', $record->exists ? 'Edit Tefillin' : 'Add Tefillin')
@section('content')

<form method="POST" action="{{ $record->exists ? route('admin.tefillin-records.update',$record) : route('admin.tefillin-records.store') }}">
  @csrf
  @if($record->exists) @method('PUT') @endif

  <div class="mb-3">
    <label>Reference No (Auto)</label>
    <input type="text" name="reference_no" value="{{ old('reference_no',$record->reference_no) }}" class="form-control" readonly>
  </div>

  <div class="mb-3">
    <label>Type</label>
    <select id="type" name="type" class="form-control">
      <option value="head" @if(old('type',$record->type)=='head') selected @endif>Head</option>
      <option value="arm" @if(old('type',$record->type)=='arm') selected @endif>Arm</option>
    </select>
  </div>

  <div class="mb-3">
    <label>Parshe Number</label>
    <select id="parshe_number" name="parshe_number" class="form-control">
      @for($i=1;$i<=4;$i++)
        <option value="{{ $i }}" @if(old('parshe_number', $record->parshe_number)==$i) selected @endif>Parshe #{{ $i }}</option>
      @endfor
    </select>
    <small class="text-muted">If Type = Arm, parshe will be forced to 1 on save</small>
  </div>

  <div class="row">
    <div class="col-md-3">
      <label>Written On</label>
      <input type="date" name="written_on" value="{{ old('written_on', optional($record->written_on)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>Bought On</label>
      <input type="date" name="bought_on" value="{{ old('bought_on', optional($record->bought_on)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>Bought From</label>
      <input name="bought_from" value="{{ old('bought_from',$record->bought_from) }}" class="form-control">
    </div>
    {{-- Seller Phone with country dropdown --}}
    <div class="col-md-3">
        <label>Phone Number</label>
        <input type="tel"
               id="seller_phone"
               name="phone_number"
               class="form-control"
               value="{{ old('phone_number', $record->phone_number) }}">
        <small class="text-muted">Select country code & enter number</small>
    </div>


  </div>

  <div class="row mt-3">
    <div class="col-md-3">
      <label>Inspected By</label>
      <input name="inspected_by" value="{{ old('inspected_by',$record->inspected_by) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>Inspected On</label>
      <input type="date" id="inspected_on" name="inspected_on" value="{{ old('inspected_on', optional($record->inspected_on)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label>User (owner)</label>
      <select name="user_id" class="form-control">
        <option value="">-- select user (optional) --</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}" @if(old('user_id',$record->user_id)==$u->id) selected @endif>{{ $u->name }} ({{ $u->email }})</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
        <label>Paid</label>
        <input name="paid" value="{{ old('paid',$record->paid) }}" class="form-control" type="number" step="0.01">
    </div>

  </div>

  <div class="mt-3">
    <button class="btn btn-success">Save</button>
    <a class="btn btn-secondary" href="{{ route('admin.tefillin-records.index') }}">Cancel</a>
  </div>
</form>
{{-- Include intl-tel-input --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#seller_phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "us",
        separateDialCode: true,
        preferredCountries: ['pk','in','us','gb'],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    // update placeholder with dial code
    function updatePlaceholder() {
        var countryData = iti.getSelectedCountryData();
        input.placeholder = '+' + countryData.dialCode + ' 3001234567';
    }

    updatePlaceholder();
    input.addEventListener('countrychange', updatePlaceholder);

    // on submit, replace value with full international number
    input.form.addEventListener("submit", function() {
        input.value = iti.getNumber();
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const type = document.getElementById('type');
  const parshe = document.getElementById('parshe_number');

  function sync(){
    if(type.value === 'arm'){
      parshe.value = '1';
      parshe.setAttribute('readonly','readonly'); // Force 1
    } else {
      parshe.removeAttribute('readonly');
    }
  }
  type.addEventListener('change', sync);
  sync();
});
</script>

@endsection
