@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ $record->exists ? '✏ Edit Mezuza Record' : '➕ Add Mezuza Record' }}</h2>

    <form action="{{ $record->exists ? route('admin.mezuza-records.update',$record->id) : route('admin.mezuza-records.store') }}" method="POST">
        @csrf
        @if($record->exists) @method('PUT') @endif

        {{-- User --}}
        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control">
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($record->user_id==$user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Address Breakdown --}}
        <div class="form-group">
            <label>House Number</label>
            <input type="text" name="house_number" class="form-control" value="{{ old('house_number',$record->house_number) }}">
        </div>
        <div class="form-group">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control" value="{{ old('room_number',$record->room_number) }}">
        </div>
        <div class="form-group">
            <label>Street Number</label>
            <input type="text" name="street_number" class="form-control" value="{{ old('street_number',$record->street_number) }}">
        </div>
        <div class="form-group">
            <label>Street Name</label>
            <input type="text" name="street_name" class="form-control" value="{{ old('street_name',$record->street_name) }}">
        </div>
        <div class="form-group">
            <label>Area / Neighborhood</label>
            <input type="text" name="area_name" class="form-control" value="{{ old('area_name',$record->area_name) }}">
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city',$record->city) }}">
        </div>
        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" class="form-control" value="{{ old('country',$record->country) }}">
        </div>

        {{-- Door Description --}}
        <div class="form-group">
            <label>Door Description</label>
            <input type="text" name="door_description" class="form-control" value="{{ old('door_description',$record->door_description) }}" placeholder="Main entrance, Balcony door, etc.">
        </div>

        {{-- Written On --}}
        <div class="form-group">
            <label>Written On</label>
            <input type="date" name="written_on" class="form-control" value="{{ old('written_on', optional($record->written_on)->format('Y-m-d')) }}">
        </div>

        {{-- Bought From --}}
        <div class="form-group">
            <label>Bought From (Store / Seller Name)</label>
            <input type="text" name="bought_from" class="form-control" value="{{ old('bought_from',$record->bought_from) }}">
        </div>

        {{-- Seller Phone with country dropdown --}}
        <div class="form-group">
            <label>Seller Phone</label>
            <input type="tel"
                   id="seller_phone"
                   name="bought_from_phone_full"
                   class="form-control"
                   value="{{ old('bought_from_phone_full', $record->bought_from_phone_code.$record->bought_from_phone_number) }}"
                   placeholder="+92 3001234567">
            <small class="text-muted">Select country code & enter number</small>
        </div>

        {{-- Paid --}}
        <div class="form-group">
            <label>Paid</label>
            <input type="number" step="0.01" name="paid" class="form-control" value="{{ old('paid',$record->paid) }}">
        </div>

        {{-- Inspected By --}}
        <div class="form-group">
            <label>Inspected By</label>
            <input type="text" name="inspected_by" class="form-control" value="{{ old('inspected_by',$record->inspected_by) }}">
        </div>

        {{-- Inspected On --}}
        <div class="form-group">
            <label>Inspected On</label>
            <input type="date" name="inspected_on" class="form-control" value="{{ old('inspected_on', optional($record->inspected_on)->format('Y-m-d')) }}">
        </div>

        {{-- Reminder Email On --}}
        <div class="form-group">
            <label>Reminder Email On</label>
            <input type="date" name="reminder_email_on" class="form-control" value="{{ old('reminder_email_on', optional($record->reminder_email_on)->format('Y-m-d')) }}">
        </div>

        <button class="btn btn-success mt-2">💾 Save</button>
        <a href="{{ route('admin.mezuza-records.index') }}" class="btn btn-secondary mt-2">⬅ Back</a>
    </form>
</div>

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
@endsection
