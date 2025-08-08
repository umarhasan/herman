@extends('user.layouts.app')
@section('title', 'Jewish Calendar {{ $gregorianYear }} - Hebrew & Gregorian')

@section('content')
<div class="container-fluid p-0 calendar-container" style="height: 88vh; overflow-y: auto; scroll-behavior: smooth;">

    <div class="text-center my-4">
        <h2>Jewish Calendar {{ $gregorianYear }} (Diaspora)</h2>
    </div>

    {{-- Top Buttons --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 px-3"
         style="position: sticky; top: 0; background: #fff; z-index: 1000; padding-top: 1rem;">
        <div class="mb-2 d-flex align-items-center gap-2">
            <button id="btnMonth" class="btn btn-outline-primary btn-sm">Month</button>
            <button id="btnList" class="btn btn-outline-secondary btn-sm">List</button>
            <a href="{{ route('user.hebcalendar.pdf') }}" class="btn btn-outline-success btn-sm">Download PDF</a>
            <select id="calendarFilter" class="form-select form-select-sm w-auto">
                <option value="both">Both Calendars</option>
                <option value="gregorian">Gregorian Only</option>
                <option value="hebrew">Hebrew Only</option>
            </select>
			<a href="{{ route('user.converter.page') }}" class="btn btn-outline-primary btn-sm">
                📆 Converter
             </a>
        </div>

        {{-- Month Navigation --}}
        <div class="mb-2" style="font-size:0px;">
            @foreach(range(1, 12) as $m)
                @php $scrollMonth = \Carbon\Carbon::create(2025, $m, 1)->format('M'); @endphp
                <a href="#month-{{ $m }}" class="btn btn-sm btn-light border mx-1 month-scroll-btn" data-target="month-{{ $m }}">{{ $scrollMonth }}</a>
            @endforeach
        </div>
    </div>

    {{-- Month View --}}
    <div id="month-view">
        @foreach(range(1, 12) as $month)
            @php
                $date = \Carbon\Carbon::create(2025, $month, 1);
                $monthName = $date->format('F');
                $daysInMonth = $date->daysInMonth;
                $startDay = $date->dayOfWeek;
            @endphp
            <div id="month-{{ $month }}" class="my-6 border p-3 rounded shadow-sm month-block">

                <div class="d-flex justify-content-center align-items-center gap-2 mt-5">
                    <button class="btn btn-outline-dark btn-sm prev-month">&laquo;</button>
                    <h4 class="m-0">{{ $gregorianTitles[$month] ?? '' }}</h4>
                    <button class="btn btn-outline-dark btn-sm next-month">&raquo;</button>
                </div>

                <div class="text-center text-danger mb-3">
                    <strong class="hebrew-header">{{ $hebrewTitles[$month] ?? '' }} {{ $hebrewMonthRanges[$month] ?? '' }}</strong>
                </div>

                <table class="table table-bordered calendar-table text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $day = 1; @endphp
                        @for($row = 0; $row < 6; $row++)
                            <tr>
                                @for($col = 0; $col < 7; $col++)
                                    @if($row === 0 && $col < $startDay)
                                        <td></td>
                                    @elseif($day > $daysInMonth)
                                        <td></td>
                                    @else
                                        @php
                                            $fullDate = \Carbon\Carbon::create(2025, $month, $day)->format('Y-m-d');
                                            $hebrewDay = $hebrewByDate[$fullDate]['hebrew'] ?? null;
                                        @endphp
                                        <td class="align-top p-1 small">
                                            <div class="calendar-date">
                                                <div class="gregorian-date fw-bold">{{ $day }}</div>
                                                @if($hebrewDay)
                                                    <div class="hebrew-date text-muted small">{{ $hebrewDay }}</div>
                                                @endif
                                            </div>
                                            @foreach($eventsByMonth[$month] as $event)
                                                @if(\Carbon\Carbon::parse($event['date'])->format('Y-m-d') == $fullDate)
                                                    <div class="event px-1 py-0 mb-1" style="background: #e3f2fd; border-left: 3px solid #2196f3;">
                                                        <small>{{ $event['title'] }}</small>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @php $day++; @endphp
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    {{-- List View --}}
    <div id="list-view" class="d-none px-3">
        @foreach($eventsByMonth as $month => $events)
            <div id="list-month-{{ $month }}" class="mb-5 border rounded p-3 shadow-sm">
                <div class="text-center text-danger mt-5 hebrew-header">
                    <strong>{{ $hebrewTitles[$month] ?? '' }} {{ $hebrewMonthRanges[$month] ?? '' }}</strong>
                </div>
                <h5>{{ $gregorianTitles[$month] ?? '' }}</h5>
                <ul class="list-group">
                    @foreach($events as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong class="gregorian-date">{{ \Carbon\Carbon::parse($event['date'])->format('d M, Y') }}</strong>
                                <span class="hebrew-date text-muted ms-2 small">{{ $event['hebrew'] ?? '' }}</span>:
                                {{ $event['title'] }}
                            </span>
                            <span class="badge bg-light text-muted">{{ $event['source'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

</div>

{{-- Styles --}}
<style>
    .calendar-container {
        height: 88vh;
        overflow-y: auto;
        scroll-behavior: smooth;
        background-color: #f9f9f9;
    }
    .calendar-header {
        background: #fff;
        padding: 20px;
        border-bottom: 1px solid #ddd;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .calendar-header h2 {
        margin-bottom: 10px;
    }
    .calendar-controls {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
    .calendar-controls .btn {
        min-width: 120px;
    }
    .month-buttons {
        overflow-x: auto;
        white-space: nowrap;
        display: flex;
        gap: 10px;
        margin: 20px 0;
        padding-bottom: 10px;
    }
    .month-buttons button {
        flex: 0 0 auto;
    }
    .month-section {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .month-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .event-item {
        padding: 8px 15px;
        border-left: 4px solid #0d6efd;
        background: #f8f9fa;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .event-item small {
        color: #6c757d;
    }
    .calendar-table td {
        height: 100px;
        vertical-align: top;
    }
    .event {
        font-size: 0.75rem;
        border-radius: 3px;
    }
    .small {
        font-size: 0.75rem;
    }
    .active-month-btn {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
    }
    .highlight-month {
        outline: 3px solid #007bff;
        transition: outline 0.3s ease-in-out;
    }
    @media print {
        .btn, .d-flex, .month-nav, .prev-month, .next-month { display: none !important; }
    }

</style>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const monthBlocks = document.querySelectorAll('.month-block');
        const monthNavButtons = document.querySelectorAll('.month-scroll-btn');
        const listView = document.getElementById('list-view');
        const monthView = document.getElementById('month-view');

        // Highlight function
        function highlightMonthBtn(monthNumber) {
            monthNavButtons.forEach(btn => {
                btn.classList.remove('active-month-btn');
                if (btn.dataset.target === `month-${monthNumber}`) {
                    btn.classList.add('active-month-btn');
                }
            });
            const monthBlock = document.getElementById(`month-${monthNumber}`);
            if (monthBlock) {
                monthBlock.classList.add('highlight-month');
                setTimeout(() => monthBlock.classList.remove('highlight-month'), 1500);
            }
        }

        // Prev/Next buttons
        monthBlocks.forEach((block, index) => {
            const prevBtn = block.querySelector('.prev-month');
            const nextBtn = block.querySelector('.next-month');

            prevBtn?.addEventListener('click', () => {
                if (index > 0) {
                    const prevBlock = monthBlocks[index - 1];
                    prevBlock.scrollIntoView({ behavior: 'smooth' });
                    highlightMonthBtn(index);
                }
            });

            nextBtn?.addEventListener('click', () => {
                if (index < monthBlocks.length - 1) {
                    const nextBlock = monthBlocks[index + 1];
                    nextBlock.scrollIntoView({ behavior: 'smooth' });
                    highlightMonthBtn(index + 2);
                }
            });
        });

        // View Toggle
        document.getElementById('btnMonth').addEventListener('click', () => {
            monthView.classList.remove('d-none');
            listView.classList.add('d-none');
        });

        document.getElementById('btnList').addEventListener('click', () => {
            monthView.classList.add('d-none');
            listView.classList.remove('d-none');
        });

        // Month nav scroll
        monthNavButtons.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const targetId = btn.dataset.target;
                const isListVisible = !listView.classList.contains('d-none');
                const finalId = isListVisible ? `list-${targetId}` : targetId;
                const target = document.getElementById(finalId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
                if (!isListVisible) {
                    const monthNumber = parseInt(targetId.replace('month-', ''));
                    highlightMonthBtn(monthNumber);
                }
                monthNavButtons.forEach(b => b.classList.remove('active-month-btn'));
                btn.classList.add('active-month-btn');
            });
        });

        // Calendar filter
        document.getElementById('calendarFilter').addEventListener('change', function() {
            const value = this.value;
            const hebrewDates = document.querySelectorAll('.hebrew-date, .hebrew-header');
            const gregorianDates = document.querySelectorAll('.gregorian-date');

            if (value === 'both') {
                hebrewDates.forEach(el => el.style.display = 'inline');
                gregorianDates.forEach(el => el.style.display = 'inline');
            } else if (value === 'gregorian') {
                hebrewDates.forEach(el => el.style.display = 'none');
                gregorianDates.forEach(el => el.style.display = 'inline');
            } else if (value === 'hebrew') {
                hebrewDates.forEach(el => el.style.display = 'inline');
                gregorianDates.forEach(el => el.style.display = 'none');
            }
        });

        // Auto-highlight January
        highlightMonthBtn(1);
    });
</script>
@endsection
