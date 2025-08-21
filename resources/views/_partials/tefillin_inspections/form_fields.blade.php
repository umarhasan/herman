@csrf

{{-- Sirf Admin ke liye User dropdown --}}
@isset($users)
<div class="mb-3">
  <label>User</label>
  <select name="user_id" class="form-control" required>
    @foreach($users as $u)
      <option value="{{ $u->id }}" {{ old('user_id', $inspection->user_id ?? '')==$u->id?'selected':'' }}>
        {{ $u->name }}
      </option>
    @endforeach
  </select>
</div>
@endisset

<div class="mb-3">
  <label>Side</label>
  <select name="side" class="form-control" required>
    <option value="">-- Select Side --</option>
    @foreach($sides as $s)
      <option value="{{ $s }}" {{ old('side', $inspection->side ?? '')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label>Part</label>
  <select name="part_name" class="form-control" required>
    <option value="">-- Select Part --</option>
    @foreach($parts as $p)
      <option value="{{ $p }}" {{ old('part_name', $inspection->part_name ?? '')==$p?'selected':'' }}>Part {{ $p }}</option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label>Date of Buy</label>
  <input type="date" class="form-control" name="date_of_buy"
         value="{{ old('date_of_buy', optional($inspection->date_of_buy ?? null)->format('Y-m-d')) }}" required>
</div>

@if(isset($inspection))
<div class="mb-3">
  <label>Next Inspection Date</label>
  <input type="text" class="form-control" value="{{ optional($inspection->next_inspection_date)->format('Y-m-d') }}" disabled>
</div>
@endif

<div class="mb-3">
  <label>Upload Tawiz Image</label>
  <input type="file" name="image" class="form-control">
  @if(!empty($inspection->image))
    <img src="{{ asset('storage/'.$inspection->image) }}" width="80" class="mt-2">
  @endif
</div>

@if(isset($inspection))
<div class="mb-3">
  <label>Status</label>
  <select name="status" class="form-control" required>
    <option value="active" {{ $inspection->status=='active'?'selected':'' }}>Active</option>
    <option value="removed" {{ $inspection->status=='removed'?'selected':'' }}>Removed</option>
  </select>
</div>
@endif

<button class="btn btn-primary">Save</button>
