@extends('student.layouts.app')
@section('title', 'Hebrew ↔ Gregorian Converter')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4 fw-bold">📅 Date Converter (Gregorian ⇄ Hebrew)</h2>

            {{-- ✅ Result shown first, hidden by default --}}
            <div id="result-area" class="d-none text-center mb-4">
                <div class="card shadow-sm rounded-4 border-0">
                    <div class="card-body">
                        <div id="converted-date" class="fs-5 text-success fw-semibold mb-2"></div>
                        <ul class="list-group" id="converted-events"></ul>
                    </div>
                </div>
            </div>

            {{-- Converter Card --}}
            <div class="card shadow rounded-4">
                <div class="card-body p-4">

                    {{-- Toggle Buttons --}}
                    <div class="mb-4 text-center">
                        <button class="btn btn-outline-primary me-2" id="btnG2H" onclick="switchMode('g2h')">Gregorian ➜ Hebrew</button>
                        <button class="btn btn-outline-success" id="btnH2G" onclick="switchMode('h2g')">Hebrew ➜ Gregorian</button>
                    </div>

                    {{-- Gregorian to Hebrew Form --}}
                    <div id="g2h-form" class="conversion-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Day</label>
                                <input type="number" id="g_day" class="form-control" min="1" max="31" value="{{ now()->day }}">
                            </div>
                            <div class="col-md-4">
                                <label>Month</label>
                                <input type="number" id="g_month" class="form-control" min="1" max="12" value="{{ now()->month }}">
                            </div>
                            <div class="col-md-4">
                                <label>Year</label>
                                <input type="number" id="g_year" class="form-control" min="1" value="{{ now()->year }}">
                            </div>
                            <div class="col-12 mt-2">
                                <input type="checkbox" id="after_sunset" class="form-check-input">
                                <label for="after_sunset" class="form-check-label">After Sunset</label>
                            </div>
                            <div class="col-12 mt-3 text-center">
                                <button class="btn btn-primary rounded-pill px-4" onclick="convertG2H()">Convert</button>
                            </div>
                        </div>
                    </div>

                    {{-- Hebrew to Gregorian Form --}}
                    <div id="h2g-form" class="conversion-form d-none">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Day</label>
                                <input type="number" id="h_day" class="form-control" min="1" max="30">
                            </div>
                            <div class="col-md-4">
                                <label>Month</label>
                                <select id="h_month" class="form-select">
                                    @foreach(['Nisan','Iyyar','Sivan','Tammuz','Av','Elul','Tishrei','Cheshvan','Kislev','Tevet','Shevat','Adar','Adar I','Adar II'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Year</label>
                                <input type="number" id="h_year" class="form-control" min="1">
                            </div>
                            <div class="col-12 mt-3 text-center">
                                <button class="btn btn-success rounded-pill px-4" onclick="convertH2G()">Convert</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
function switchMode(mode) {
    document.getElementById('g2h-form').classList.toggle('d-none', mode !== 'g2h');
    document.getElementById('h2g-form').classList.toggle('d-none', mode !== 'h2g');
    document.getElementById('result-area').classList.add('d-none');

    document.getElementById('btnG2H').classList.toggle('active', mode === 'g2h');
    document.getElementById('btnH2G').classList.toggle('active', mode === 'h2g');
}

async function convertG2H() {
    const day = document.getElementById('g_day').value;
    const month = document.getElementById('g_month').value;
    const year = document.getElementById('g_year').value;
    const afterSunset = document.getElementById('after_sunset').checked;

    const response = await fetch("{{ route('student.converter.g2h') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ day, month, year, afterSunset })
    });

    const data = await response.json();
    displayResult(data, 'hebrew');
}

async function convertH2G() {
    const day = document.getElementById('h_day').value;
    const month = document.getElementById('h_month').value;
    const year = document.getElementById('h_year').value;

    const response = await fetch("{{ route('student.converter.h2g') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ day, month, year })
    });

    const data = await response.json();
    displayResult(data, 'gregorian');
}

function displayResult(data, type) {
    const resultDiv = document.getElementById('converted-date');
    const eventList = document.getElementById('converted-events');

    resultDiv.innerHTML = type === 'hebrew'
        ? `Hebrew Date: <strong>${data.hebrew}</strong>`
        : `Gregorian Date: <strong>${data.gy}-${data.gm}-${data.gd}</strong>`;

    eventList.innerHTML = '';
    if (data.events && data.events.length) {
        data.events.forEach(event => {
            eventList.innerHTML += `<li class="list-group-item d-flex justify-content-between align-items-center">
                ${event.title}
                <small class="text-muted">${event.source}</small>
            </li>`;
        });
    } else {
        eventList.innerHTML = `<li class="list-group-item text-muted">No events found.</li>`;
    }

    document.getElementById('result-area').classList.remove('d-none');
}
</script>


@endsection
